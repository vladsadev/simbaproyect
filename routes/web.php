<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\InspectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    //Equipos
    Route::get('/catalogo', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/catalogo/crear', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::get('/catalogo/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::get('/catalogo/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::post('/catalogo', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::patch('/catalog/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/catalog/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');


    //Inspecciones
    Route::get('/inspecciones', [InspectionController::class, 'index'])->name('inspection.index');
    Route::get('/inspecciones/crear/{equipment}', [InspectionController::class, 'create'])->name('inspection.create');
    Route::post('/inspecciones', [InspectionController::class, 'store'])->name('inspection.store');


    // Inspecciones - Issues
    Route::post('/api/inspection-issues/temporary', [InspectionIssueController::class, 'storeTemporary'])
        ->name('inspection.issues.temporary');
    Route::post('/api/inspection-issues', [InspectionIssueController::class, 'store'])
        ->name('inspection.issues.store');


    Route::get('/malla', function () {
        return view('dashboard.malla');
    })->name('malla');

    Route::get('/reportes', function () {
        return view('reports.index');
    })->name('reportes');
});





