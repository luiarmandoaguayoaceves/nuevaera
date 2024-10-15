<?php

namespace App\Http\Controllers;

use App\Models\Imagenes;
use Illuminate\Http\Request;

class GaleriaController extends Controller
{
    //
    public function imagenes() {
        return Imagenes::all();
    }
}
