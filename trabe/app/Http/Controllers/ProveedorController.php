<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedorControler extends Controller
{
    public function index()
{
    $proveedores = proveedores::all(); // o datos de prueba
    return view('proveedores', compact('proveedores'));
}
}
