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
            $validated = $request->validated();

            // Crear la inspección
            $inspection = Inspection::create([
                'equipment_id' => $validated['equipment_id'],
                'user_id' => Auth::id(),
                'inspection_date' => now(),
                'status' => 'completada',
                'observations' => $validated['observations'] ?? null,
                // Mapear los checkboxes correctamente
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
                'epp_complete' => $request->has('epp'),
            ]);

            // Si hay problemas reportados (desde sesión temporal o request)
            if ($request->session()->has('inspection_issues')) {
                $issues = $request->session()->get('inspection_issues');
                foreach ($issues as $issue) {
                    $inspection->issues()->create($issue);
                }
                $request->session()->forget('inspection_issues');
            }

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
