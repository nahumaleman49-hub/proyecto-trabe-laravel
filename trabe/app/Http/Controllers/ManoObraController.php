<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManoObraController extends Controller
{
    public function index(){
    $manoObra = manodeobracontac::all(); // o datos de prueba
    return view('mano-de-obra', compact('mano-de-obra'));
    }
}
