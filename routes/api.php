<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\CabellosController;
use App\Http\Controllers\IdiomasController;
use App\Http\Controllers\EnfermedadesController;
use App\Http\Controllers\NacionalidadesController;
use App\Http\Controllers\DenunciaController;

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


Route::get('/getColores',[ColoresController::class,'index']);
Route::get('/getNacionalidades',[NacionalidadesController::class,'index']);
Route::get('/getIdiomas',[IdiomasController::class,'index']);
Route::get('/getCabellos',[CabellosController::class,'index']);
Route::get('/getEnfermedades',[EnfermedadesController::class,'index']);


Route::post('/denunciar',[DenunciaController::Class,'store']);






Route::get('/historial-denuncias/{user_id}',[DenunciaController::Class,'getHistorialDenuncias']);
Route::get('/denuncias-aceptadas',[DenunciaController::class,'denunciasAceptadas']);
Route::get('/mostrar-denuncia/{id}',[DenunciaController::class,'mostrarDenuncia']);
////Route::post('/esFamoso',[DenunciaController::class,'verificarSiEsFamoso']);










