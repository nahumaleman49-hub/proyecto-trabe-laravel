<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function index() {
    $cotizacion = Cotizacion::all(); // o datos de prueba
    return view('/cotizaciones/cotizaciones', compact('cotizacion'));
    }
    public function create()
{
    return view('cotizaciones.nueva');
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
public function store(Request $request)
{
    $validated = $request->validate([
        'projectName' => 'required|string|max:255',
        'projectType' => 'required|string|max:100',
        'projectLocation' => 'required|string|max:255',
        'startDate' => 'nullable|date',
        'endDate' => 'nullable|date|after_or_equal:startDate',
        'description' => 'nullable|string',
        'clientName' => 'required|string|max:255',
        'clientEmail' => 'required|email|max:255',
        'clientPhone' => 'nullable|string|max:20',
        'labourCost' => 'required|numeric|min:0',
        'materialsCost' => 'required|numeric|min:0',
        'equipmentCost' => 'nullable|numeric|min:0',
        'overheadPercentage' => 'nullable|numeric|min:0|max:100',
        'profitMargin' => 'nullable|numeric|min:0|max:100',
        'materialsList' => 'nullable|array',
        'materialsList.*.categoria' => 'nullable|string',
        'materialsList.*.material' => 'required|string',
        'materialsList.*.cantidad' => 'required|numeric|min:0.01',
        'materialsList.*.unidad' => 'required|string',
        'materialsList.*.precioUnitario' => 'required|numeric|min:0',
    ]);

    session(['cotizacion_temporal' => $validated]);

    return response()->json([
        'redirect_url' => route('cotizaciones.seleccion-vista')
    ]);
}

public function seleccionVista()
{
    if (!session()->has('cotizacion_temporal')) {
        return redirect()->route('cotizaciones.nueva');
    }
    return view('cotizaciones.seleccion-vista');
}

public function vistaCliente()
{
    $data = session('cotizacion_temporal');
    return view('cotizaciones.vista-cliente', compact('data'));
}

public function vistaIngeniero()
{
    $data = session('cotizacion_temporal');
    return view('cotizaciones.vista-ingeniero', compact('data'));
}

}
