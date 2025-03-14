<?php

namespace App\Http\Controllers\Master;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\PsUnit;
use Illuminate\Http\Request;

class PsUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $psUnits = PsUnit::paginate(10);

        return view('master.ps_units.index', compact('psUnits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.ps_units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'  => 'required|in:PS4,PS5', // Validasi unique untuk type
            'stock' => 'required|integer',
        ]);

        PsUnit::create($validated);
        Alert::success('Success', 'PS Unit Created Successfully');
        return redirect()->route('ps_units.index');
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
    public function edit(PsUnit $psUnit)
    {
        return view('master.ps_units.edit', compact('psUnit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PsUnit $psUnit)
    {
        $validated = $request->validate([
            'type' => 'required|in:PS4,PS5|unique:ps_units,type,' . $psUnit->id, // Mengecualikan type yang sedang diedit
            'stock' => 'required|integer',
        ]);

        $psUnit->update($validated);
        Alert::success('Success', 'PS Unit Updated Successfully');
        return redirect()->route('ps_units.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PsUnit $psUnit)
    {
        $psUnit->delete();
        Alert::success('Success', 'PS Unit Deleted Successfully');
        return redirect()->route('ps_units.index');
    }
}
