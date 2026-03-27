<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index() {
    $cotizaciones = Cotizacion::all(); // o datos de prueba
    return view('cotizaciones', compact('cotizaciones'));
    }
//     public function index(): View
// {
//     $cotizaciones = [
//         (object) [
//             'id' => 'Q-2024-001',
//             'project_name' => 'Renovación Residencial',
//             'cliente' => 'Juan García',
//             'date' => '20 Feb 2026',
//             'value' => '$45,000',
//             'status' => 'Pendiente',
//         ],
//     ];
//     return view('cotizaciones', compact('cotizaciones'));
// }
}
