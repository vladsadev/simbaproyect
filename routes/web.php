<?php

use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/eq', [\App\Http\Controllers\EquipmentController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::get('/catalogo', [EquipmentController::class, 'index'])->name('catalogo');
    Route::get('/catalogo/create', [EquipmentController::class, 'create'])->name('equipment.create');



    Route::get('/inspecciones', function () {
        return view('inspection.index');
    })->name('inspecciones');

    Route::get('/malla', function () {
        return view('dashboard.malla');
    })->name('malla');

    Route::get('/reportes', function () {
        return view('reports.index');
    })->name('reportes');
});





//Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth');
//Route::post('/jobs', [JobController::class, 'store'])->middleware('auth');
//
//
//Route::get('/search', SearchController::class);
//Route::get('/tags/{tag:name}', TagController::class);
//
//
//Route::middleware('guest')->group(function () {
//
//    Route::get('/register', [RegisterUserController::class, 'create']);
//    Route::post('/register', [RegisterUserController::class, 'store']);
//
//    Route::get('/login', [SessionController::class, 'create']);
//    Route::post('/login', [SessionController::class, 'store']);
//});
//
//Route::delete('/logout', [SessionController::class, 'destroy'])->middleware('auth');

