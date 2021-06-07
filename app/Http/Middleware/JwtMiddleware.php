<?php

namespace App\Http\Middleware;

use App\Repositories\AuthRepository;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            //get current authenticate user
            $user = app(AuthRepository::class)->authUser();
            if (!$user) {
                //not found
                return response()->json(['message' => 'unauthorized.'], 401);
            }
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['message' => 'unauthorized.'], 401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => 'token is expired'], 401);
            }else{
                return response()->json(['message' => 'unauthorized.'], 401);
            }
        }

        return $next($request);
    }
}
