<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('clientes', ClienteController::class);

//genera ruta de Prestamos

Route::resource('prestamos',PrestamoController ::class);

//genera ruta de Pagos
Route::resource('pagos', PagoController::class);
Route::get('pago/create/{prestamo}', [PagoController::class, 'create'])->name('pago.create');

