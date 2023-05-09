<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\Auth\User;
class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        if(!$request->route()->getName() == 'login'){
            if (! $request->header('Authorization')) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $token = str_replace('Bearer ', '', $request->header('Authorization'));
            if (! $user = User::where('api_token', $token)->first()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            Auth::login($user);
        }

        return $next($request);
    }
}
