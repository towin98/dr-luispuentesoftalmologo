<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cliente\ClienteController;
use App\Http\Controllers\Parametro\ParametroController;
use App\Http\Controllers\PermissionController;

/*Rutas de autenticacacion*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

/*Rutas Controlador PermissionController*/
Route::get('/informacion-usuario', [PermissionController::class, 'informacionUsuario'])->middleware('auth:sanctum');


/*Rutas MENU*/
Route::group(['prefix' => 'cliente', /*'middleware' => 'auth:sanctum'*/] , function(){
    // Artisan::call('cache:clear');
    Route::get('/listar/{tipo_persona}', [ClienteController::class, 'listar']);
    Route::resource('/', ClienteController::class)->only(['store']);
    Route::post('/actualizar/{id}', [ClienteController::class, 'update']);
    Route::get('/mostrar/{id}', [ClienteController::class, 'show']);
});

Route::group(['prefix' => 'parametro'/* , 'middleware' => 'auth:sanctum' */] , function(){
    Route::resource('/',  ParametroController::class)->only(['store']);
    Route::put('/{id}', [ParametroController::class, 'update']);
    Route::get('/buscar', [ParametroController::class, 'buscar']);
    Route::get('/{parametrica}/{id}', [ParametroController::class, 'show']);
});
