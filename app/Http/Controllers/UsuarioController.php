<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class UsuarioController extends Controller
{
    public function index()
    {
        return Usuario::all();
    }

    public function store(Request $request)
    {
        // Validar primero el token de Firebase
        $token = $request->bearerToken();

        try {
            $verifiedIdToken = Firebase::auth()->verifyIdToken($token);
            $firebaseUid = $verifiedIdToken->claims()->get('sub');

            $usuario = Usuario::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'contraseña' => bcrypt($request->contraseña), // ¡Nunca guardes contraseñas en texto plano!
                'firebase_uid' => $firebaseUid,
            ]);

            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Autenticación fallida: ' . $e->getMessage()], 401);
        }
    }

    public function getByUid($uid)
    {
        $usuario = Usuario::where('firebase_uid', $uid)->first();

        if (!$usuario) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        return $usuario;
    }

    public function registrarFirebaseUser(Request $request)
    {
        $usuario = new Usuario();
        $usuario->nombre = $request->nombre;
        $usuario->email = $request->email;
        $usuario->firebase_uid = $request->firebase_uid;
        $usuario->save();

        return response()->json(['message' => 'Usuario creado correctamente'], 201);
    }

    public function obtenerPorEmail($email)
    {
        $usuario = Usuario::where('email', $email)->first();

        if ($usuario) {
            return response()->json($usuario);
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }


}