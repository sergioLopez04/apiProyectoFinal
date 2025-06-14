<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProyectoController extends Controller
{
    public function index()
    {
        return Proyecto::with(['tareas', 'actividades'])->get();
    }



    public function porUsuario($id)
    {
        return Proyecto::where('id_creador', $id)
            ->with(['tareas', 'actividades'])
            ->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'id_creador' => 'required|integer',
            'firestore_id' => 'sometimes|string',
            'fecha_creacion' => 'sometimes|numeric',
            'tiempo_acumulado' => 'sometimes|numeric',
        ]);

        if ($request->has('fecha_creacion')) {
            $validated['fecha_creacion'] = Carbon::createFromTimestampMs($request->input('fecha_creacion'));
        }

        $proyecto = Proyecto::create($validated);


        return response()->json($proyecto->load('miembros'), 201);
    }


    public function actualizarTiempoAcumulado(Request $request, $id)
    {
        $request->validate([
            'tiempo_acumulado' => 'required|integer',
        ]);

        $proyecto = Proyecto::findOrFail($id);
        $proyecto->tiempo_acumulado += $request->input('tiempo_acumulado');
        $proyecto->save();

        return response()->json(['mensaje' => 'Tiempo actualizado correctamente', 'tiempo_acumulado' => $proyecto->tiempo_acumulado]);
    }

    public function destroy($id)
    {
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }

        $proyecto->delete();

        return response()->json(['mensaje' => 'Proyecto eliminado con éxito'], 200);
    }

    public function obtenerPorUsuario($id_creador)
    {
        try {
            return Proyecto::where('id_creador', $id_creador)->get();
        } catch (\Exception $e) {
            abort(500, 'Error interno del servidor');
        }
    }


    /*public function show($id)
    {
        $proyecto = Proyecto::find($id);
        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }
        return response()->json($proyecto);
    }*/

    public function show($id)
    {
        $proyecto = Proyecto::with('miembros')->find($id);
        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }
        return response()->json($proyecto);
    }

    public function cogerNombre($id)
    {
        $usuario = Usuario::find($id);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json([
            'nombre' => $usuario->nombre
        ]);
    }



    /*public function unirse(Request $request, $proyectoId)
    {
        $userId = $request->input('user_id');
        $usuario = Usuario::find($userId);

        if (!$usuario->proyectos()->where('proyecto_id', $proyectoId)->exists()) {
            $usuario->proyectos()->attach($proyectoId);
        }

        return response()->json(['mensaje' => 'Usuario unido al proyecto correctamente']);
    }*/

    public function unirse(Request $request, $proyectoId)
    {
        $userId = $request->input('user_id');
        $usuario = Usuario::find($userId);

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if (!$usuario->proyectos()->where('proyecto_id', $proyectoId)->exists()) {
            $usuario->proyectos()->attach($proyectoId);
        }

        return response()->json(['mensaje' => 'Usuario unido al proyecto correctamente']);
    }

    public function miembros($proyectoId)
    {
        $proyecto = Proyecto::with('miembros')->find($proyectoId);

        if (!$proyecto) {
            return response()->json(['error' => 'Proyecto no encontrado'], 404);
        }

        return response()->json($proyecto->miembros);
    }






}
