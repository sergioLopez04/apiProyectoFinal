<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/prueba', function () {
    return response()->json(['mensaje' => '¡API funcionando!']);
});


Route::apiResource('proyectos', ProyectoController::class);
Route::apiResource('usuarios', UsuarioController::class);
Route::apiResource('tareas', TareaController::class);
Route::apiResource('actividades', ActividadController::class);

Route::post('/registrar-firebase-user', [AuthController::class, 'registrarFirebaseUser']);
Route::post('/proyectos/{id}/actualizar-tiempo', [ProyectoController::class, 'actualizarTiempoAcumulado']);
Route::get('/usuarios/email/{email}', [UsuarioController::class, 'obtenerPorEmail']);
Route::get('/proyectos/usuario/{id_creador}', [ProyectoController::class, 'obtenerPorUsuario']);
Route::post('/proyectos/{proyectoId}/unirse', [ProyectoController::class, 'unirse']);
Route::get('usuarios/{id}/tareas', [TareaController::class, 'tareasPorUsuario']);
Route::get('proyectos/{id}/tareas', [TareaController::class, 'tareasPorProyecto']);
Route::put('tareas/{id}/estado', [TareaController::class, 'actualizarEstado']);
Route::post('/actividades', [ActividadController::class, 'store']);
Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy']);
Route::get('/usuarios/firebase/{firebase_uid}', [UsuarioController::class, 'getByFirebaseUid']);
Route::get('/proyectos/{proyectoId}/miembros', [ProyectoController::class, 'miembros']);

