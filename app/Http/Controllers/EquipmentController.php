<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Models\EquipmentType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $eqs = Equipment::all();
//        $eqs = Equipment::with('equipmentType')->get();
        $equipment = Equipment::with('equipmentType')->paginate(6);

        return view('equipment.index', [
            'equipment' => $equipment
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $equipment = EquipmentType::all();
//
//        return $equipment;
        return view('equipment.create', [
            'equipment' => $equipment
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        $validated = request()->validate([
            'equipment_type_id' => 1,
            'code' => ['required'],
            'brand' => ['required'],
            'model' => ['required'],
            'year' => ['required', 'integer'],
            'status' => ['required'],
            'hours_worked' => ['required', 'numeric'],
        ]);

        Equipment::create($validated);

        return redirect(route('equipment.index'));

    }

    /**
     * Display the specified resource.
     */
//    public function show(Equipment $equipment)
    public function show(Equipment $equipment)
    {

//        $equipment = Equipment::find($equipment);

        return view('equipment.show', [
            'equipment' => $equipment
        ]);
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
