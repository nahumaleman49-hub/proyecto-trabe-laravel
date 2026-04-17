<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CategoriaController;
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

Route::get('/mano-de-obra', [ManoDeObraController::class, 'index'])->name('mano.de.obra');


Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/agregar', [CategoriaController::class, 'agregar'])->name('categorias.agregar');
Route::post('/categorias/guardar', [CategoriaController::class, 'guardar'])->name('categorias.guardar');
Route::get('/categorias/editar/{id}', [CategoriaController::class, 'editar'])->name('categorias.editar');
Route::put('/categorias/actualizar/{id}', [CategoriaController::class, 'actualizar'])->name('categorias.actualizar');
Route::delete('/categorias/eliminar/{id}', [CategoriaController::class, 'eliminar'])->name('categorias.eliminar');

Route::get('/materiales', [MaterialController::class, 'index'])->name('materiales.index');
Route::get('/materiales/agregar', [MaterialController::class, 'agregar'])->name('materiales.agregar');
Route::post('/materiales/guardar', [MaterialController::class, 'guardar'])->name('materiales.guardar');
Route::get('/materiales/editar/{id}', [MaterialController::class, 'editar'])->name('materiales.editar');
Route::put('/materiales/actualizar/{id}', [MaterialController::class, 'actualizar'])->name('materiales.actualizar');
Route::delete('/materiales/eliminar/{id}', [MaterialController::class, 'eliminar'])->name('materiales.eliminar');
