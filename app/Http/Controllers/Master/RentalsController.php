<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\PsUnit;
use App\Models\Rentals;
use Carbon\Carbon;
use Midtrans\Snap;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalsController extends Controller
{

    public function __construct()
    {
        \Midtrans\Config::$serverKey    = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized  = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds        = config('services.midtrans.is3ds');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Rentals::whereDate('start_date', '>=', $request->start)
                ->whereDate('end_date',   '<=', $request->end)
                ->get(['id', 'customer_name', 'customer_contact', 'status', 'start_date', 'end_date']);

            // Format data untuk FullCalendar
            $events = $data->map(function ($rental) {
                return [
                    'id'            => $rental->id,
                    'title'         => $rental->customer_name,
                    'start'         => $rental->start_date,
                    'end'           => $rental->end_date,
                    'description'   => $rental->customer_contact,
                    'status'        => $rental->status,
                ];
            });

            return response()->json($events);
        }

        $psUnits = PsUnit::get();
        return view('master.rentals.index', compact('psUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Menambahkan log untuk memastikan data yang diterima
            \Log::info('Received request data:', $request->all());

            // Memeriksa apakah type adalah 'add'
            if ($request->type == 'add') {
                // Parsing tanggal start dan end
                $startDate  = Carbon::parse($request->start_date);
                $endDate    = Carbon::parse($request->end_date);
                $dateDiff   = abs($endDate->diffInDays($startDate));

                // Mendapatkan harga dasar (base rate) untuk unit yang dipilih
                $pricing    = Pricing::where('ps_unit_id', $request->ps_unit_id)->first();

                // Inisialisasi biaya tambahan akhir
                $totalCost = $dateDiff * $pricing->base_rate;

                // Variabel weekend surcharge yang diinisialisasi di luar loop
                $weekendSurcharge = 0;

                // Loop untuk memeriksa setiap hari dalam periode booking
                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                    // Jika hari adalah Sabtu atau Minggu, tambahkan biaya tambahan
                    if ($date->isWeekend()) {
                        $weekendSurcharge = $pricing->weekend_surcharge; // Menambahkan weekend surcharge per hari weekend
                    }
                }

                // Menambahkan weekend surcharge ke total biaya
                $totalAmount = $totalCost + $weekendSurcharge;

                // Menyimpan data rental ke database
                $rentals = Rentals::create([
                    'ps_unit_id'        => $request->ps_unit_id,
                    'customer_name'     => $request->customer_name,
                    'customer_contact'  => $request->customer_contact,
                    'customer_email'    => $request->customer_email,
                    'start_date'        => $request->start_date,
                    'end_date'          => $request->end_date,
                    'cost'              => $totalCost, // Gunakan totalCost yang sudah dihitung
                    'weekend_surcharge' => $weekendSurcharge,
                    'amount'            => $totalAmount
                ]);

                // Create payload for Midtrans Snap API
                $payload = [
                    'transaction_details' => [
                        'order_id'     => $rentals->customer_name . $rentals->created_at,
                        'gross_amount' => $rentals->amount,
                    ],
                    'customer_details' => [
                        'first_name'   => $rentals->customer_name,
                        'email'        => $rentals->customer_email,
                    ],
                    'item_details' => [
                        [
                            'id'               => $rentals->customer_name . $rentals->created_at,
                            'price'            => $rentals->amount,
                            'quantity'         => 1,
                            'name'             => 'Payment to ' . config('app.name'),
                            'brand'            => 'Payment',
                            'category'         => 'Payment',
                            'merchant_name'    => config('app.name'),
                        ],
                    ],
                ];

                // Get snap token
                $snapToken = \Midtrans\Snap::getSnapToken($payload);

                // Save the snap token in rentals
                $rentals->snap_token = $snapToken;
                $rentals->save();

                // Mengirimkan response JSON setelah data berhasil disimpan
                return response()->json([
                    'status'        => 'success',
                    'id'            => $rentals->id,
                    'snap_token'    => $snapToken,
                ]);
            } else {
                // Jika type bukan 'add', return response error
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid request type, expected "add".',
                ]);
            }
        } catch (\Exception $e) {
            // Jika terjadi error, tangkap dan kirim response error
            return response()->json([
                'status' => 'error',
                'message' => 'Error generating snap token: ' . $e->getMessage(),
            ]);
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rentals = Rentals::findOrFail($id);
        return view('master.rentals.show', compact('rentals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
