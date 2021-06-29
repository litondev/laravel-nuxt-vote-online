<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\{
    SigninRequest,
};

class AuthController extends Controller
{
    public function signin(SigninRequest $request)
    {    
        try{
            throw_if(!$token = auth()->attempt($request->validated()),new \Exception("Password atau email salah"));
        
            return $this->respondWithToken($token);
        }catch(\Exception $e){
            \Log::channel("coex")->info($e->getMessage());

            return response()->json([
                "status" => "Failed",
                "message" => "Password atau email salah"
            ],500);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => "Success",
            'message' => 'Berhasil logout'
        ]);
    }

    public function refresh()
    {
         try{            
            return $this->respondWithToken(auth()->refresh());
        }catch(\Exception $e){
            \Log::channel("coex")->info($e->getMessage());
            
            $response = ["status" => "Failed"];

            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException){            
                $response['message'] = 'Token is blacklist';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {                
                $response['message'] = 'Token is expired but when refresh failed';
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {        
                $response['message'] = 'Token is invalid';
            }else{            
                $response['message'] = 'Token Not Found';       
            }

            return response()->json($response,401);            
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 'Success',
            'message' => 'Berhasil Masuk',
            'token_type' => 'Bearer',
            'access_token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}