<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::get('/', fn() => redirect()->route('gallery.index'));
Route::get('/galeria', [GalleryController::class, 'index'])->name('gallery.index');

