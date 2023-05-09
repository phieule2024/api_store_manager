<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = Auth::user();
        $user->generateApiToken();

        return response()->json([
            'user' => $user,
            'access_token' => $user->api_token,
            'token_type' => 'Bearer',
        ]);
    }
}
