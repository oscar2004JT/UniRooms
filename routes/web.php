<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddroomC;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/bienvenida', function () {
    return view('bienvenida');
})->name('bienvenida');

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');

Route::get('/addroom', function () {
    return view('addroom');
})->name('addroom');

Route::get('/buscarroom', function () {
    return view('buscarroom');
})->name('buscarroom');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::post('/rooms', [AddroomC::class, 'store'])->name('addroomC');

