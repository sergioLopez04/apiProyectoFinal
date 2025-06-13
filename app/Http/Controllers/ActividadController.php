<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index(Request $request)
    {
        $userId = $request->query('userId');

        if (!$userId) {
            return response()->json(['error' => 'Se requiere userId'], 400);
        }

        $actividades = Actividad::where('user_id', $userId)->get();

        return response()->json($actividades);
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
        Log::info('Entrando en store()', $request->all());

        try {
            $request->validate([
                'proyecto_id' => 'required|exists:proyectos,id',
                'user_id' => 'required|integer',
                'fecha' => 'required|date',
                'duracion' => 'required|integer|min:1',
                'tiempo_inicio' => 'required|integer',
                'tiempo_fin' => 'required|integer',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación', $e->errors());
            return response()->json(['error' => $e->errors()], 422);
        }

        $fecha = Carbon::parse($request->fecha)->startOfDay(); // normalizamos la fecha al inicio del día

        // Ver si ya existe una actividad para ese día y proyecto
        $actividad = Actividad::where('proyecto_id', $request->proyecto_id)
            ->whereDate('fecha', $fecha)
            ->first();

        if ($actividad) {
            Log::info('Actualizando actividad existente', ['id' => $actividad->id]);
            // Actualizamos: sumamos duración y actualizamos tiempoFin
            $actividad->update([
                'duracion' => $actividad->duracion + $request->duracion,
                'tiempo_inicio' => $request->tiempo_inicio,
                'tiempo_fin' => $request->tiempo_fin,
            ]);
        } else {
            Log::info('Creando nueva actividad');
            // Creamos nuevo registro
            $actividad = Actividad::create([
                'proyecto_id' => $request->proyecto_id,
                'user_id' => $request->user_id,
                'fecha' => $fecha,
                'tiempo_inicio' => $request->tiempo_inicio,
                'tiempo_fin' => $request->tiempo_fin,
                'duracion' => $request->duracion
            ]);
        }

        return response()->json($actividad, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Actividad $actividad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Actividad $actividad)
    {
        //
    }
}
