<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\AjaxController;

/*
|-----------------------------------------------------------------------
| Web Routes
|-----------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/
//ruta raiz va al login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/perfil', [LoginController::class, 'perfil'])->name('perfil');
Route::put('/perfil', [LoginController::class, 'actualizarPerfil'])->name('perfil.actualizar');
    

Route::middleware('auth')->group(function () {
    //Rutas con autenticacion
    // home page
    Route::get('/home', function () {return view('home');})->name('home');
    // Cotizaciones
    //Vistas de cotizacion (faltan las rutas para editar, mostrar detalles y generar pdf)
    Route::get('/cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones');
    Route::get('/cotizaciones/nueva', [CotizacionController::class, 'create'])->name('cotizaciones.nueva');
    Route::post('/cotizaciones', [CotizacionController::class, 'store'])->name('cotizaciones.guardar');
    Route::get('/cotizaciones/{id}', [CotizacionController::class, 'show'])->name('cotizaciones.ver');
    Route::get('/cotizaciones/{id}/editar', [CotizacionController::class, 'edit'])->name('cotizaciones.editar');
    Route::put('/cotizaciones/{id}', [CotizacionController::class, 'update'])->name('cotizaciones.actualizar');
    Route::get('/cotizaciones/{id}/pdf', [CotizacionController::class, 'pdf'])->name('cotizaciones.pdf');
    //endpoints ajax para los selects dinamicos de las cotizaciones
    Route::prefix('ajax')->middleware('auth')->group(function () {
        Route::get('/clientes', [AjaxController::class, 'clientes']);                // para autocomplete
        Route::get('/categorias-materiales', [AjaxController::class, 'categoriasMateriales']);
        Route::get('/materiales-por-categoria/{id}', [AjaxController::class, 'materialesPorCategoria']);
        Route::get('/proveedores-por-material/{id}', [AjaxController::class, 'proveedoresPorMaterial']);
        Route::get('/categorias-servicios', [AjaxController::class, 'categoriasServicios']);
        Route::get('/servicios-por-categoria/{id}', [AjaxController::class, 'serviciosPorCategoria']);
        Route::get('/proveedores-por-servicio/{id}', [AjaxController::class, 'proveedoresPorServicio']);
    });
    //rutas de proveedores
    Route::get('/proveedores', [ProveedorController::class, 'index'])->name('proveedores');
    Route::get('/proveedores/crear', [ProveedorController::class, 'crear'])->name('proveedores.crear');
    Route::post('/proveedores', [ProveedorController::class, 'guardar'])->name('proveedores.guardar');
    Route::get('/proveedores/{id}/editar', [ProveedorController::class, 'editar'])->name('proveedores.editar');
    Route::put('/proveedores/{id}', [ProveedorController::class, 'actualizar'])->name('proveedores.actualizar');
    Route::delete('/proveedores/{id}', [ProveedorController::class, 'eliminar'])->name('proveedores.eliminar');
    // Rutas de vinculación para Proveedores -> Materiales
    Route::post('/proveedores/vincular-material', [ProveedorController::class, 'vincularMaterial'])->name('proveedores.vincularMaterial');
    Route::delete('/proveedores/desvincular-material/{proveedor}/{material}', [ProveedorController::class, 'desvincularMaterial'])->name('proveedores.desvincularMaterial');
    // Rutas de vinculación para Proveedores -> Servicios
    Route::post('/proveedores/vincular-servicio', [ProveedorController::class, 'vincularServicio'])->name('proveedores.vincularServicio');
    Route::delete('/proveedores/desvincular-servicio/{proveedor}/{servicio}', [ProveedorController::class, 'desvincularServicio'])->name('proveedores.desvincularServicio');

    //falta mano de obra (servicios)
    Route::get('/mano-de-obra', [ServicioController::class, 'index'])->name('mano.de.obra');
    Route::get('/mano-de-obra/agregar', [ServicioController::class, 'agregar'])->name('mano.de.obra.agregar');
    Route::post('/mano-de-obra', [ServicioController::class, 'guardar'])->name('mano.de.obra.guardar');
    Route::get('/mano-de-obra/{id}/modificar', [ServicioController::class, 'editar'])->name('mano.de.obra.modificar');
    Route::put('/mano-de-obra/{id}', [ServicioController::class, 'actualizar'])->name('mano.de.obra.actualizar');
    Route::delete('/mano-de-obra/{id}', [ServicioController::class, 'eliminar'])->name('mano.de.obra.eliminar');
    // Rutas para la vinculación bidireccional de Mano de Obra (Servicios)
    Route::post('/mano-de-obra/vincular-proveedor', [ServicioController::class, 'vincularProveedor'])->name('mano.de.obra.vincularProveedor');
    Route::delete('/mano-de-obra/desvincular-proveedor/{servicio}/{proveedor}', [ServicioController::class, 'desvincularProveedor'])->name('mano.de.obra.desvincularProveedor');

    //modulo de clientes funciona al 100%
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes');
    Route::get('/clientes/agregar', [ClienteController::class, 'agregar'])->name('clientes.agregar');
    Route::post('/clientes', [ClienteController::class, 'guardar'])->name('clientes.guardar');
    Route::get('/clientes/{id}/modificar', [ClienteController::class, 'editar'])->name('clientes.modificar');
    Route::put('/clientes/{id}', [ClienteController::class, 'actualizar'])->name('clientes.actualizar');
    Route::delete('/clientes/{id}', [ClienteController::class, 'eliminar'])->name('clientes.eliminar');

    //modulo de proyectos funciona al 100%
    Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos');
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
    Route::post('/materiales/importar-csv', [MaterialController::class, 'importarDesdeCSV'])->name('materiales.importar');

    // Ruta especial para la creación rápida vía AJAX
    Route::post('/materiales/guardar-rapido', [MaterialController::class, 'guardarRapido'])->name('materiales.guardarRapido');
    Route::post('/materiales/vincular-proveedor', [MaterialController::class, 'vincularProveedor'])->name('materiales.vincularProveedor');
Route::delete('/materiales/desvincular-proveedor/{material}/{proveedor}', [MaterialController::class, 'desvincularProveedor'])->name('materiales.desvincularProveedor');

});