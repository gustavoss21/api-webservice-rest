<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        if (!$token) {
            return response()->json(['erro'=>'Usuário ou senha inválido!'], 403);
        }
        return response()->json(['token' => $token]);
    }

    public function me(){
        $user = auth()->user();
        return response()->json($user);
    }

    public function refresh(){
        $token = auth('api')->refresh();
        return response()->json($token);
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['token status'=> 'expirado ou removido!']);
    }
}
