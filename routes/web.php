<?php

use App\Http\Controllers\NavegacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NavegacionController::class, 'index'])->name('index');
