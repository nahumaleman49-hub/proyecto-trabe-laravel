<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManoObraController;
use App\Http\Controllers\ClienteController;

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

Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores');
Route::get('/proveedores/crear', [ProveedorController::class, 'crear'])->name('proveedores.crear');
Route::get('/proveedores/{proveedor}', [ProveedorController::class, 'ver'])->name('proveedores.ver');
Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'editar'])->name('proveedores.editar');

Route::get('/mano-de-obra', [ManoObraController::class, 'index'])->name('mano.de.obra');
Route::get('/mano-de-obra/agregar', [ManoObraController::class, 'agregar'])->name('mano.de.obra.agregar');
Route::post('/mano-de-obra', [ManoObraController::class, 'guardar'])->name('mano.de.obra.guardar');

Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
Route::get('/clientes/agregar', [ClienteController::class, 'agregar'])->name('clientes.agregar');
Route::post('/clientes', [ClienteController::class, 'guardar'])->name('clientes.guardar');
Route::get('/clientes/{id}/modificar', [ClienteController::class, 'editar'])->name('clientes.modificar');
Route::put('/clientes/{id}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
Route::delete('/clientes/{id}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

Route::get('/materiales', [MaterialController::class, 'index'])->name('materiales');

