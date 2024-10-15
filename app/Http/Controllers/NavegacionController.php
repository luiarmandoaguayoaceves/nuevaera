<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavegacionController extends Controller
{
    //
    public function index(){
        return view('principal');
    }

    public function nosotros(){
        return view('nosotros');
    }
}
