<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\MaterialController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/cotizaciones', [CotizacionController::class, 'cotizaciones']);

Route::get('/proveedores', [ProveedorController::class, 'proveedores']);

Route::get('/materiales', [MaterialController::class, 'materiales']);

Route::get('/mano-de-obra', [ManoObraController::class, 'mano-de-obra']);

