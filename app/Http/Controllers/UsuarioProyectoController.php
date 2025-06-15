<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UsuarioProyectoController extends Controller
{
    public function getProyectoIdsPorUsuario(int $userId)
    {
        // Consulta directa a la tabla pivot usuarios_proyectos
        $ids = DB::table('usuario_proyecto')
            ->where('usuario_id', $userId)
            ->pluck('proyecto_id');

        return response()->json($ids);
    }
}
