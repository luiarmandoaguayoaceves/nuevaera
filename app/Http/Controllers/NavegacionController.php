<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavegacionController extends Controller
{
    //
    public function index()
    {
        $productos = Product::with(['images', 'category'])
            ->where('activo', true)
            ->latest()
            ->paginate(12);

        return view('principal', compact('productos'));
    }

    public function nosotros()
    {
        return view('nosotros');
    }
}
