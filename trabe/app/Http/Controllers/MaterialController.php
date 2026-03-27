<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(){
    $materiales = materiales::all(); // o datos de prueba
    return view('materiales', compact('materiales'));
    }
}
