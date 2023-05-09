<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (!Auth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            $user->generateApiToken();

            $data = [
                'user' => $user,
                'access_token' => $user->api_token,
                'token_type' => 'Bearer',
            ];
            return $this->returnResult([
                "error" => 0,
                "data" => $data,
            ]);
        } catch (\Exception $e) {
            return $this->responseJson(CODE_ERROR, $e->getMessage());
        }
    }
}
