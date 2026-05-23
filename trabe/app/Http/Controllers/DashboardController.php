<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;

class DashboardController extends Controller
{
    public function index()
    {
        $cotizaciones = Cotizacion::with('proyecto.cliente')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('cotizaciones'));
    }
}