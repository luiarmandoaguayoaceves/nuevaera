<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        // Carga relaciones necesarias (images, category)
        $productos = Product::with(['images','category'])
            ->where('activo', true)
            ->latest()
            ->paginate(12);

        // cat/tallas para filtros (puedes generarlos desde BD)
        $categorias = ['sandalia','tacón','casual','confort'];
        $tallas     = [22,23,24,25,26,27];

        return view('gallery.index', compact('productos','categorias','tallas'));
    }
}