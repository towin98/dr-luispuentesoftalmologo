<?php

use App\Http\Controllers\Agenda\CitaClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HistoriaClinica\AntecedentesController;
use App\Http\Controllers\HistoriaClinica\CargarArchivosController;
use App\Http\Controllers\HistoriaClinica\FormulaAnteojosController;
use App\Http\Controllers\Paciente\PacienteController;
use App\Http\Controllers\HistoriaClinica\HistoriaClinicaController;
use App\Http\Controllers\Parametro\ParametroController;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Artisan;

/*Rutas de autenticacacion*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/password/change', [AuthController::class, 'passwordChange'])->middleware('auth:sanctum');

/*Rutas Controlador PermissionController*/
Route::get('/informacion-usuario', [PermissionController::class, 'informacionUsuario'])->middleware('auth:sanctum');

Route::post('/password/email', [AuthController::class, 'resetPassword']);
Artisan::call('cache:clear');

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

    // Evolucion
    Route::get('/buscar/evolucion/{numero_documento}', [HistoriaClinicaController::class, 'buscarEvolucion']);
    Route::post('/guardar/evolucion', [HistoriaClinicaController::class, 'storeEvolucion']);
    Route::get('/numero-evolucion/{id_paciente}', [HistoriaClinicaController::class, 'obtenerNumeroEvolucion']);
    Route::get('/mostrar/evolucion/{id}', [HistoriaClinicaController::class, 'showEvolucion']);
    Route::post('/descargar/evolucion/refracciones', [HistoriaClinicaController::class, 'descargar']);
    Route::post('/actualizar/evolucion/{id}', [HistoriaClinicaController::class, 'updateEvolucion']);
    Route::post('/delete/evolucion/{id}', [HistoriaClinicaController::class, 'destroyEvolucion']);

    // Formula Anteojos
    Route::post('/guardar/formula-anteojos', [FormulaAnteojosController::class, 'store']);
    Route::put('/actualizar/formula-anteojos/{id}', [FormulaAnteojosController::class, 'update']);
    Route::get('/mostrar/formula-anteojos/{id}', [FormulaAnteojosController::class, 'show']);
    Route::post('/delete/formula-anteojos/{id}', [FormulaAnteojosController::class, 'destroy']);
    Route::get('/listar/formula-anteojos/{numero_documento}', [FormulaAnteojosController::class, 'listar']);
    Route::get('/cosecutivo-formula-anteojos/{id_paciente}', [FormulaAnteojosController::class, 'obtenerNumeroFormulaAnteojos']);
    Route::post('/pdf/formula-anteojos', [FormulaAnteojosController::class, 'reportePdf']);

    // Antecedentes
    Route::post('/guardar/antecedentes', [AntecedentesController::class, 'store']);
    Route::put('/actualizar/antecedentes/{id}', [AntecedentesController::class, 'update']);
    Route::get('/mostrar/antecedentes/{id}', [AntecedentesController::class, 'show']);
    Route::post('/delete/antecedentes/{id}', [AntecedentesController::class, 'destroy']);
    Route::get('/listar/antecedentes/{numero_documento}', [AntecedentesController::class, 'listar']);
    Route::get('/cosecutivo-antecedentes/{id_paciente}', [AntecedentesController::class, 'obtenerNumeroAntecedente']);

    // cargar archivo
    Route::post('/guardar/cargar-archivo', [CargarArchivosController::class, 'store']);
    Route::post('/actualizar/cargar-archivo/{id}', [CargarArchivosController::class, 'update']);
    Route::get('/mostrar/cargar-archivo/{id}', [CargarArchivosController::class, 'show']);
    Route::post('/delete/cargar-archivo/{id}', [CargarArchivosController::class, 'destroy']);
    Route::get('/listar/cargar-archivo/{numero_documento}', [CargarArchivosController::class, 'listar']);
    Route::get('/cosecutivo-cargar-archivo/{id_paciente}', [CargarArchivosController::class, 'obtenerConsecutivo']);
    Route::post('/descargar/archivo', [CargarArchivosController::class, 'descargar']);
});

Route::group(['prefix' => 'agenda'/* , 'middleware' => 'auth:sanctum' */] , function(){
    Route::post('/busqueda-paciente-autocomplete', [CitaClienteController::class, 'busquedaAutocompletePaciente']);
    Route::get('/cargar-informacion-paciente', [CitaClienteController::class, 'cargarInfoPaciente']);
    Route::post('/guardar/cita-paciente', [CitaClienteController::class, 'store']);
    Route::put('/actualizar/cita-paciente/{id}', [CitaClienteController::class, 'update']);
    Route::get('/mostrar/cita-paciente/{id}', [CitaClienteController::class, 'show']);
    Route::post('/delete/cita-paciente/{id}', [CitaClienteController::class, 'destroy']);
    Route::get('/listar/citas-pacientes', [CitaClienteController::class, 'listar']);
});

Route::group(['prefix' => 'parametro'/* , 'middleware' => 'auth:sanctum' */] , function(){
    Route::resource('/',  ParametroController::class)->only(['store']);
    Route::put('/{id}', [ParametroController::class, 'update']);
    Route::get('/buscar', [ParametroController::class, 'buscar']);
    Route::get('/{parametrica}/{id}', [ParametroController::class, 'show']);
});
