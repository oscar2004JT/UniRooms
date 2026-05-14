<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddroomC;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\FavoritaController;
use App\Http\Controllers\ArriendoController;

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::get('/bienvenida', fn() => view('bienvenida'))->name('bienvenida');
Route::get('/inicio', fn() => view('inicio'))->name('inicio');
Route::get('/nueva', fn() => view('nueva'))->name('nueva');
Route::get('/register', fn() => view('auth.register'))->name('register');
Route::get('/', fn() => view('welcome'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
});

Route::get('/propietarios/{id}/perfil', [PropietarioController::class, 'perfil'])
    ->name('propietarios.perfil');


Route::middleware(['auth', 'student.profile'])->group(function () {

    Route::get('/buscarroom', [AddroomC::class, 'index'])->name('buscarroom');

    Route::get('/habitaciones/{pension}', [AddroomC::class, 'show'])->name('rooms.show');

    Route::post('/pensiones/{pension}/favoritas', [FavoritaController::class, 'store'])
        ->name('favoritas.store');

    Route::get('/mis-favoritas', [FavoritaController::class, 'index'])
        ->name('favoritas.index');

    Route::delete('/pensiones/{pension}/favoritas', [FavoritaController::class, 'destroy'])
        ->name('favoritas.destroy');

    Route::get('/pensiones/{pension}/reservar', [ArriendoController::class, 'create'])
        ->name('arriendos.create');

    Route::post('/arriendos', [ArriendoController::class, 'store'])
        ->name('arriendos.store');

    Route::get('/mis-arriendos', [ArriendoController::class, 'index'])
        ->name('arriendos.index');

    Route::get('/arriendos/{arriendo}', [ArriendoController::class, 'show'])
        ->name('arriendos.show');

    Route::delete('/arriendos/{arriendo}', [ArriendoController::class, 'destroy'])
        ->name('arriendos.destroy');
});


Route::middleware(['auth', 'owner.profile'])->group(function () {

    Route::get('/addroom', [AddroomC::class, 'create'])->name('addroom');

    Route::post('/rooms', [AddroomC::class, 'store'])->name('addroomC');

    Route::get('/propietario/habitaciones', [PropietarioController::class, 'misHabitaciones'])
        ->name('propietario.habitaciones');

    Route::get('/propietario/habitaciones/{pension}', [PropietarioController::class, 'verDetalle'])
        ->name('propietario.habitacion.detalle');

    Route::get('/propietario/pensiones/{pension}/editar', [PropietarioController::class, 'edit'])
        ->name('pension.edit');

    Route::put('/propietario/pensiones/{pension}', [PropietarioController::class, 'update'])
        ->name('pension.update');

    Route::get('/propietario/solicitudes', [PropietarioController::class, 'solicitudesReservas'])
        ->name('propietario.solicitudes');

    Route::get('/propietario/habitaciones-reservadas', [PropietarioController::class, 'habitacionesReservadas'])
        ->name('propietario.reservadas');

    Route::patch(
        '/propietario/solicitudes/{arriendo}/cambiar-estado',
        [PropietarioController::class, 'cambiarEstadoSolicitud']
    )->name('propietario.solicitudes.cambiarEstado');

    Route::get(
        '/propietario/habitaciones/{pension}/estudiante',
        [PropietarioController::class, 'perfilEstudiante']
    )->name('propietario.habitacion.perfilestudiante');
});
