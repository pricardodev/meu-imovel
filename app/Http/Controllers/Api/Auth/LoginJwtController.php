<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']);

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string'
            ])->validate();

        //attempt responsável por autenticar
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        // para saber qual usuário tem que informar o token, depois de deslogado o token vai para blacklist
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
