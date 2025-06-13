<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\UsuarioController;

// Ruta de prueba raíz
Route::get('/', function () {
    return '¡Laravel funciona!';
});

Route::get('/debug-log', function () {
    return file_exists(storage_path('logs/laravel.log'))
        ? nl2br(file_get_contents(storage_path('logs/laravel.log')))
        : 'No log file found';
});


/*
// Usuarios (opcional)
Route::get('/usuarios', [UsuarioController::class, 'index']);
Route::post('/usuarios', [UsuarioController::class, 'store']);
Route::get('/usuarios/firebase/{uid}', [UsuarioController::class, 'getByUid']);

// Proyectos (sin CSRF, porque lo desactivamos en Kernel)
Route::get('/proyectos', [ProyectoController::class, 'index'])->name('proyectos.index');
Route::post('/proyectos', [ProyectoController::class, 'store'])->name('proyectos.store');
Route::get('/proyectos/{id}', [ProyectoController::class, 'show'])->name('proyectos.show');
Route::put('/proyectos/{id}', [ProyectoController::class, 'update'])->name('proyectos.update');
Route::delete('/proyectos/{id}', [ProyectoController::class, 'destroy'])->name('proyectos.destroy');

// Ruta para filtrar por usuario
Route::get('/proyectos/usuario/{id}', [ProyectoController::class, 'porUsuario']);
*/
