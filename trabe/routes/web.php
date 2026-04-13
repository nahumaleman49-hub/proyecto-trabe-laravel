<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\MaterialController;
/*
|-----------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones');
Route::get('/cotizaciones/nueva', [CotizacionController::class, 'create'])->name('cotizaciones.nueva');
Route::post('/cotizaciones/guardar', [CotizacionController::class, 'store'])->name('cotizaciones.guardar');
Route::get('/cotizaciones/seleccion-vista', [CotizacionController::class, 'seleccionVista'])->name('cotizaciones.seleccion-vista');
Route::get('/cotizaciones/vista-cliente', [CotizacionController::class, 'vistaCliente'])->name('cotizaciones.vista-cliente');
Route::get('/cotizaciones/vista-ingeniero', [CotizacionController::class, 'vistaIngeniero'])->name('cotizaciones.vista-ingeniero');

Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores');
Route::get('/proveedores/crear', [ProveedorController::class, 'crear'])->name('proveedores.crear');
Route::get('/proveedores/{proveedor}', [ProveedorController::class, 'ver'])->name('proveedores.ver');
Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'editar'])->name('proveedores.editar');

Route::get('/mano-de-obra', [ManoDeObraController::class, 'index'])->name('mano-de-obra');
Route::get('/materiales', [MaterialController::class, 'index'])->name('materiales');

