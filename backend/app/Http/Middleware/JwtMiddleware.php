<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        try {            
            JWTAuth::parseToken()->authenticate();                    
        } catch (\Exception $e) {                          
            $response = [
                "status" => "Failed"
            ];

            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){
                $response['message'] = 'Token is blacklist';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $response['message'] = 'Token is expired';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $response['message'] = 'Token is invalid';
            }else{
                $response["message"] = 'Token not found';
            }

            return response()->json($response,401);
        }

        return $next($request);
    }
}