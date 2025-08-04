<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\EquipmentType;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $eqs = Equipment::all();
//        $eqs = Equipment::with('equipmentType')->get();
        $eqs = Equipment::with('equipmentType')->paginate(5);

        return view('equipments.index', [
            'eqs' => $eqs
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $eTypes = EquipmentType::all();

        return $eTypes;
        return view('equipments.create', [
            'eTypes' => $eTypes
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        //
    }
}
