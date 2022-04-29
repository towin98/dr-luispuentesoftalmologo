<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Paciente\PacienteController;
use App\Http\Controllers\HistoriaClinica\HistoriaClinicaController;
use App\Http\Controllers\Parametro\ParametroController;
use App\Http\Controllers\PermissionController;

/*Rutas de autenticacacion*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/*Rutas Controlador PermissionController*/
Route::get('/informacion-usuario', [PermissionController::class, 'informacionUsuario'])->middleware('auth:sanctum');


/*Rutas MENU*/
Route::group(['prefix' => 'paciente', /*'middleware' => 'auth:sanctum'*/] , function(){
    // Artisan::call('cache:clear');
    Route::get('/listar', [PacienteController::class, 'listar']);
    Route::resource('/', PacienteController::class)->only(['store']);
    Route::post('/actualizar/{id}', [PacienteController::class, 'update']);
    Route::get('/mostrar/{id}', [PacienteController::class, 'show']);
});

Route::group(['prefix' => 'historia-clinica', /*'middleware' => 'auth:sanctum'*/] , function(){
    Route::get('/buscar', [HistoriaClinicaController::class, 'buscar']);
    Route::get('/buscar/evolucion/{numero_documento}', [HistoriaClinicaController::class, 'buscarEvolucion']);
    Route::post('/guardar/evolucion', [HistoriaClinicaController::class, 'storeEvolucion']);
    Route::get('/numero-evolucion/{id_paciente}', [HistoriaClinicaController::class, 'obtenerNumeroEvolucion']);
});

Route::group(['prefix' => 'parametro'/* , 'middleware' => 'auth:sanctum' */] , function(){
    Route::resource('/',  ParametroController::class)->only(['store']);
    Route::put('/{id}', [ParametroController::class, 'update']);
    Route::get('/buscar', [ParametroController::class, 'buscar']);
    Route::get('/{parametrica}/{id}', [ParametroController::class, 'show']);
});
