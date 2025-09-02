<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



Route::get('/',function(){
    return view('admin.dashboard');
})->name('dashboard');

Auth::routes();
//genera ruta de clientes

Route::resource('clientes', ClienteController::class);

//genera ruta de Prestamos

Route::resource('prestamos',PrestamoController ::class);