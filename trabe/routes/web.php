<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ManoObraController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProveedorController;

/*
|-----------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/
// home page
Route::get('/', function () {
    return view('home');
})->name('home');
//Vistas de cotizacion (faltan las rutas para editar, eliminar cotizaciones, mostrar detalles y generar pdf)
Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones');
Route::get('/cotizaciones/nueva', [CotizacionController::class, 'create'])->name('cotizaciones.nueva');
Route::post('/cotizaciones/guardar', [CotizacionController::class, 'store'])->name('cotizaciones.guardar');
//rutas de proveedores
Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores');
Route::get('/proveedores/crear', [ProveedorController::class, 'crear'])->name('proveedores.crear');
Route::post('/proveedores', [ProveedorController::class, 'guardar'])->name('proveedores.guardar');
Route::get('/proveedores/{proveedor}/editar', [ProveedorController::class, 'editar'])->name('proveedores.editar');
Route::put('/proveedores/{proveedor}', [ProveedorController::class, 'actualizar'])->name('proveedores.actualizar');
Route::delete('/proveedores/{proveedor}', [ProveedorController::class, 'eliminar'])->name('proveedores.eliminar');
//Mano de obra sigue incompleto
Route::get('/mano-de-obra', [ManoObraController::class, 'index'])->name('mano.de.obra');
Route::get('/mano-de-obra/agregar', [ManoObraController::class, 'agregar'])->name('mano.de.obra.agregar');
Route::post('/mano-de-obra', [ManoObraController::class, 'guardar'])->name('mano.de.obra.guardar');
//modulo de clientes funciona al 100%
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
Route::get('/clientes/agregar', [ClienteController::class, 'agregar'])->name('clientes.agregar');
Route::post('/clientes', [ClienteController::class, 'guardar'])->name('clientes.guardar');
Route::get('/clientes/{id}/modificar', [ClienteController::class, 'editar'])->name('clientes.modificar');
Route::put('/clientes/{id}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
Route::delete('/clientes/{id}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

//modulo de proyectos funciona al 100%
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::get('/proyectos/agregar', [ProyectoController::class, 'agregar'])->name('proyectos.agregar');
Route::post('/proyectos', [ProyectoController::class, 'guardar'])->name('proyectos.guardar');
Route::get('/proyectos/{id}/modificar', [ProyectoController::class, 'editar'])->name('proyectos.modificar');
Route::put('/proyectos/{id}', [ProyectoController::class, 'actualizar'])->name('proyectos.actualizar');
Route::delete('/proyectos/{id}', [ProyectoController::class, 'eliminar'])->name('proyectos.eliminar');
//modulo de categorias funciona al 100%
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/agregar', [CategoriaController::class, 'agregar'])->name('categorias.agregar');
Route::post('/categorias/guardar', [CategoriaController::class, 'guardar'])->name('categorias.guardar');
Route::get('/categorias/editar/{id}', [CategoriaController::class, 'editar'])->name('categorias.editar');
Route::put('/categorias/actualizar/{id}', [CategoriaController::class, 'actualizar'])->name('categorias.actualizar');
Route::delete('/categorias/eliminar/{id}', [CategoriaController::class, 'eliminar'])->name('categorias.eliminar');
//modulo de materiales funciona al 100%
Route::get('/materiales', [MaterialController::class, 'index'])->name('materiales.index');
Route::get('/materiales/agregar', [MaterialController::class, 'agregar'])->name('materiales.agregar');
Route::post('/materiales/guardar', [MaterialController::class, 'guardar'])->name('materiales.guardar');
Route::get('/materiales/editar/{id}', [MaterialController::class, 'editar'])->name('materiales.editar');
Route::put('/materiales/actualizar/{id}', [MaterialController::class, 'actualizar'])->name('materiales.actualizar');
Route::delete('/materiales/eliminar/{id}', [MaterialController::class, 'eliminar'])->name('materiales.eliminar');
