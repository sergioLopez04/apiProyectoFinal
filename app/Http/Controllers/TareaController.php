<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoMiembro;
use App\Models\Tarea;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tarea = Tarea::create([
            'proyecto_id' => $request->input('proyectoId'),
            'descripcion' => $request->input('descripcion'),
            'completada' => $request->input('completada', false),
            'prioridad' => $request->input('prioridad'),
            'fecha_inicio' => $request->input('fechaInicio') ? Carbon::createFromTimestampMs($request->input('fechaInicio')) : null,
            'fecha_fin' => $request->input('fechaFin') ? Carbon::createFromTimestampMs($request->input('fechaFin')) : null,
        ]);

        return response()->json([
            'id' => $tarea->id,
            'proyectoId' => $tarea->proyecto_id,
            'descripcion' => $tarea->descripcion,
            'completada' => $tarea->completada,
            'prioridad' => $tarea->prioridad,
            'fechaInicio' => $tarea->fecha_inicio ? $tarea->fecha_inicio->getTimestampMs() : null,
            'fechaFin' => $tarea->fecha_fin ? $tarea->fecha_fin->getTimestampMs() : null,
        ]);
    }

    public function tareasPorUsuario($id)
    {
        $proyectosCreados = Proyecto::where('id_creador', $id)->pluck('id');
        $proyectosMiembro = ProyectoMiembro::where('user_id', $id)->pluck('proyecto_id');
        $todosLosProyectos = $proyectosCreados->merge($proyectosMiembro)->unique();

        $tareas = Tarea::whereIn('proyecto_id', $todosLosProyectos)->get();

        $tareasTransformadas = $tareas->map(function ($tarea) {
            return [
                'id' => $tarea->id,
                'proyectoId' => $tarea->proyecto_id,
                'descripcion' => $tarea->descripcion,
                'completada' => $tarea->completada,
                'prioridad' => $tarea->prioridad,
                'fechaInicio' => optional($tarea->fecha_inicio)->getTimestampMs(),
                'fechaFin' => optional($tarea->fecha_fin)->getTimestampMs(),
            ];
        });

        return response()->json($tareasTransformadas);
    }

    public function tareasPorProyecto($id)
    {
        $tareas = Tarea::where('proyecto_id', $id)->get();

        $tareasTransformadas = $tareas->map(function ($tarea) {
            return [
                'id' => $tarea->id,
                'proyectoId' => $tarea->proyecto_id,
                'descripcion' => $tarea->descripcion,
                'completada' => $tarea->completada,
                'prioridad' => $tarea->prioridad,
                'fechaInicio' => optional($tarea->fecha_inicio)->getTimestampMs(),
                'fechaFin' => optional($tarea->fecha_fin)->getTimestampMs(),
            ];
        });

        return response()->json($tareasTransformadas);
    }

    public function actualizarEstado(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);
        $tarea->completada = $request->input('completada');
        $tarea->save();

        return response()->json(['success' => true]);
    }








    /**
     * Display the specified resource.
     */
    public function show(Tarea $tarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarea $tarea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarea $tarea)
    {
        //
    }
}
