<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Log;

class AuthController extends Controller
{
    

    public function registrarFirebaseUser(Request $request)
    {
        try {
            $usuario = new Usuario();
            $usuario->nombre = $request->nombre;
            $usuario->email = $request->email;
            $usuario->firebase_uid = $request->firebase_uid;

            if ($usuario->save()) {
                return response()->json(['message' => 'Usuario creado correctamente'], 201);
            } else {
                Log::error('No se pudo guardar el usuario en la base de datos.');
                return response()->json(['message' => 'Error al guardar el usuario'], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error al registrar usuario: ' . $e->getMessage());
            return response()->json(['message' => 'Error interno', 'error' => $e->getMessage()], 500);
        }
    }



}
