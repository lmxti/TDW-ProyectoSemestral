<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BebidaController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\TraspasoController;
use App\Http\Controllers\EgresoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para el modelo de bebida
Route::prefix('/bebida')->group(function(){
    Route::post('/create', 'App\Http\Controllers\BebidaController@createBebida');
    Route::get('/view', 'App\Http\Controllers\BebidaController@viewBebida');
    Route::put('/update', 'App\Http\Controllers\BebidaController@updateBebida');
    Route::delete('/delete', 'App\Http\Controllers\BebidaController@deleteBebida');
    Route::get('/viewAll', 'App\Http\Controllers\BebidaController@viewAllBebidas');
});

// Rutas para el modelo de bodega
Route::prefix('/bodega')->group(function(){
    Route::post('/create', 'App\Http\Controllers\BodegaController@createBodega');
    Route::get('/view', 'App\Http\Controllers\BodegaController@viewBodega');
    Route::put('/update', 'App\Http\Controllers\BodegaController@updateBodega');
    Route::delete('/delete', 'App\Http\Controllers\BodegaController@deleteBodega');
    Route::get('/viewAll', 'App\Http\Controllers\BodegaController@viewAllBodegas');
    
    Route::get('/viewStock', 'App\Http\Controllers\BodegaController@viewStock');
    Route::get('/viewAllStock', 'App\Http\Controllers\BodegaController@viewAllStock');
});

// Rutas para el modelo de ingreso
Route::prefix('/ingreso')->group(function(){
    Route::post('/create', 'App\Http\Controllers\IngresoController@createIngreso');
    Route::get('/view', 'App\Http\Controllers\IngresoController@viewIngreso');
    Route::get('/viewAll', 'App\Http\Controllers\IngresoController@viewAllIngreso');
    Route::delete('/delete', 'App\Http\Controllers\IngresoController@deleteIngreso');
});

// Rutas para el modelo de traspaso
Route::prefix('/traspaso')->group(function(){
    Route::post('/create', 'App\Http\Controllers\TraspasoController@createTraspaso');
    Route::get('/viewAll', 'App\Http\Controllers\TraspasoController@viewAllTraspaso');
    Route::delete('/delete', 'App\Http\Controllers\TraspasoController@deleteTraspaso');
});

// Rutas para el modelo de egreso
Route::prefix('/egreso')->group(function(){
    Route::post('/create', 'App\Http\Controllers\EgresoController@createEgreso');
    Route::get('/viewAll', 'App\Http\Controllers\EgresoController@viewAllEgreso');
    Route::delete('/delete', 'App\Http\Controllers\EgresoController@deleteEgreso');
});
