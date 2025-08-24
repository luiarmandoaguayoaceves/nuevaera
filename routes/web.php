<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AuthenticatedSessionController;

// PÚBLICAS (tuyas)
Route::get('/', fn() => redirect()->route('gallery.index'));
Route::get('/galeria', [GalleryController::class, 'index'])->name('gallery.index');

// ADMIN (protegidas)
Route::middleware('auth')->prefix('admin/galeria')->name('admin.galeria.')->group(function () {
    Route::get('/', [GalleryController::class, 'admin'])->name('index');
    Route::put('/producto/{product}', [GalleryController::class, 'updateProduct'])->name('producto.update');
    Route::post('/producto/{product}/images', [GalleryController::class, 'uploadImages'])->name('images.upload');
    Route::patch('/images/{image}', [GalleryController::class, 'updateImage'])->name('images.update');
    Route::patch('/images/{image}/primary', [GalleryController::class, 'makePrimary'])->name('images.primary');
    Route::patch('/images/sort', [GalleryController::class, 'sortImages'])->name('images.sort');
    Route::delete('/images/{image}', [GalleryController::class, 'destroyImage'])->name('images.destroy');
});





Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    // aquí tus rutas admin de galería...
});
