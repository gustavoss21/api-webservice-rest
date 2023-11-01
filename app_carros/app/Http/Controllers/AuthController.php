<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

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
}
