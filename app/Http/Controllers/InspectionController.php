<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionRequest;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Http\Requests\UpdateInspectionRequest;
use Illuminate\Support\Facades\Auth;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('inspection.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Equipment $equipment)
    {

        return view('inspection.create', [
            'equipment' => $equipment,
            'user' => Auth::user()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInspectionRequest $request)
    {
        try {
            // Crear la inspección con los datos validados
            $inspection = Inspection::create([
                'equipment_id' => $request->validated()['equipment_id'],
                'user_id' => Auth::id(), // Obtener el ID del usuario autenticado
                'inspection_date' => Carbon::now(),
                'status' => 'completada', // o el estado que manejes
                'observations' => $request->validated()['observations'] ?? null,
                // Agregar los campos de checklist
                'cuchara_checked' => $request->has('cuchara'),
                'llantas_checked' => $request->has('llantas'),
                'articulacion_checked' => $request->has('articulacion'),
                'cilindro_checked' => $request->has('cilindro'),
                'botellones_checked' => $request->has('botellones'),
                'zbar_checked' => $request->has('zbar'),
                'dogbone_checked' => $request->has('dogbone'),
                'brazo_checked' => $request->has('brazo'),
                'tablero_checked' => $request->has('tablero'),
                'extintores_checked' => $request->has('extintores'),
                // EPP
                'epp_complete' => $request->has('epp_complete'),
            ]);

            return redirect()
                ->route('inspection.show', $inspection)
                ->with('success', 'Inspección creada exitosamente');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al crear la inspección: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInspectionRequest $request, Inspection $inspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        //
    }
}
