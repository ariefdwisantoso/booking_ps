<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Pricing;
use App\Models\PsUnit;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pricing = Pricing::with('psUnit')->paginate(10);

        return view('master.pricing.index', compact('pricing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $psUnits = PsUnit::leftJoin('pricing', 'ps_units.id', '=', 'pricing.ps_unit_id')
        ->whereNull('pricing.ps_unit_id') // Memastikan tidak ada relasi di tabel pricing
        ->select('ps_units.id', 'ps_units.type') // Menampilkan semua data dari ps_units
        ->get();

        return view('master.pricing.create', compact('psUnits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ps_unit_id'        => 'required|exists:ps_units,id',
            'base_rate'         => 'required|numeric',
            'weekend_surcharge' => 'nullable|numeric',
        ]);

        Pricing::create($validated);
        return redirect()->route('pricing.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pricing $pricing)
    {
        $psUnits = PsUnit::whereDoesntHave('pricing') // Mengambil ps_units yang tidak memiliki relasi di pricing
        ->orWhere('id', $pricing->ps_unit_id) // Menampilkan ps_unit_id yang sudah ada pada pricing yang sedang diedit
        ->get();

        return view('master.pricing.edit', compact('psUnits', 'pricing'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pricing $pricing)
    {
        // Validasi input, pastikan ps_unit_id ada di ps_units dan base_rate valid
        $validated = $request->validate([
            'ps_unit_id'        => 'required|exists:ps_units,id', // Cek apakah ps_unit_id ada di tabel ps_units
            'base_rate'         => 'required|numeric',
            'weekend_surcharge' => 'nullable|numeric',
        ]);

        // Update data
        $pricing->update($validated);

        return redirect()->route('pricing.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pricing $pricing)
    {
        $pricing->delete();
        return redirect()->route('pricing.index');
    }
}
