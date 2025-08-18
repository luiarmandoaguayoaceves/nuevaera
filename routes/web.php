<?php

use App\Http\Controllers\GaleriaController;
use App\Http\Controllers\NavegacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductController;

Route::get('/', [NavegacionController::class, 'index'])->name('index');

Route::get('/nosotros', [NavegacionController::class, 'nosotros'])->name('nosotros');

Route::get('/imagenes', [GaleriaController::class, 'imagenes']);


Route::get('/galeria', [ProductoController::class, 'galeria'])->name('galeria');

// routes/web.php

Route::resource('productos', ProductController::class)->parameters([
  'productos' => 'producto'   // para nombres en español
]);

Route::get('/galeria', [ProductController::class, 'index'])->name('galeria');





