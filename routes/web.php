<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\ReservacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invitados (sin sesión)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store'])->middleware('throttle:10,1');
});

/*
|--------------------------------------------------------------------------
| Usuarios autenticados
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('equipos.index'));
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    // Ambos roles
    Route::get('/equipos', [EquipoController::class, 'index'])->name('equipos.index');
    Route::get('/reservaciones', [ReservacionController::class, 'index'])->name('reservaciones.index');
    Route::get('/reservaciones/{reservacion}', [ReservacionController::class, 'show'])->name('reservaciones.show');
    Route::delete('/reservaciones/{reservacion}', [ReservacionController::class, 'destroy'])->name('reservaciones.destroy');

    // Solo estudiantes: reservar
    Route::post('/equipos/{equipo}/reservar', [ReservacionController::class, 'store'])
        ->middleware('rol:estudiante')
        ->name('reservaciones.store');

    // Solo administradores: CRUD de equipos
    Route::resource('equipos', EquipoController::class)
        ->except(['index', 'show'])
        ->middleware('rol:administrador');
});
