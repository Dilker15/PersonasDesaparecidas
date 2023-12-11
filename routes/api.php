<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColoresController;
use App\Http\Controllers\CabellosController;
use App\Http\Controllers\IdiomasController;
use App\Http\Controllers\EnfermedadesController;
use App\Http\Controllers\NacionalidadesController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AvistamientoController;
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



//                                  DENUNCIAS


Route::get('/getColores',[ColoresController::class,'index']);
Route::get('/getNacionalidades',[NacionalidadesController::class,'index']);
Route::get('/getIdiomas',[IdiomasController::class,'index']);
Route::get('/getCabellos',[CabellosController::class,'index']);
Route::get('/getEnfermedades',[EnfermedadesController::class,'index']);
Route::post('/denunciar',[DenunciaController::Class,'store']);


// HISTORIAL Y DATOS DE UNA DENUNCIA
Route::get('/historial-denuncias/{user_id}',[DenunciaController::Class,'getHistorialDenuncias']);
Route::get('/denuncias-aceptadas',[DenunciaController::class,'denunciasAceptadas']);
Route::get('/mostrar-denuncia/{id}',[DenunciaController::class,'mostrarDenuncia']);



// esta ruta de abajo es para cuando se ingresa a la app ,lo que hace es registrar el token del device.
Route::post('/registrar-token',[DenunciaController::class,'registrarToken']);






//                                      AVISTAMIENTOS


// ESTA RUTA ES PARA LOS AVISTAMIENTOS LA PRIMERA ES PARA MOSTRAR TODOS LOS AVISTAMIENTOS DE UNA DENUNCIAS.
Route::get('/historial-avistamientos/{denuncia_id}',[AvistamientoController::class,'getHistorialAvistamientos']);

// ESTA RUTA MUESTRA LOS DATOS DE UNA AVISTAMIENTO ESPECIFICO.
Route::get('/mostrar-avistamiento/{id}',[AvistamientoController::class,'show']);

// ESTA RUTA CREA UN AVISTAMIENTO , REGISTRA UN AVISTAMIENTO
Route::post('/registrar-avistamiento',[AvistamientoController::class,'store']);


// ESTA RUTA MUESTRA LA UBICACION DE CADA AVISTAMIENTO QUE TIENE UNA DENUNCIA Y SU HORA PARA SE MOSTRADA EN EL MAPA.
Route::post('/tracking',[AvistamientoController::class,'mostrarFechasHoras']);


//ESTA RUTA MOSTRARA LOS FILTROS POR FECHAS EN LA APP.
Route::get('/filtros/{filtro_id}',[DenunciaController::class,'denunciasFiltradas']);

Route::post('/probar-luxand',[DenunciaController::class,'enviarLuxand']);



Route::post('/escaner',[DenunciaController::class,'escanearPersona']);


// auth jwt
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UsersController::class,'createUser']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/registrar-avistamiento',[AvistamientoController::class,'store']);
});



// Route::post('/registrar-user',[UsersController::class,'createUser']);
// Route::post('/login',[UsersController::class,'login']);









