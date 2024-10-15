<?php

use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\NavegacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NavegacionController::class, 'index'])->name('index');

Route::get('/nosotros', [NavegacionController::class, 'nosotros'])->name('nosotros');

Route::get('/imagenes', [GaleriaController::class, 'imagenes']);


