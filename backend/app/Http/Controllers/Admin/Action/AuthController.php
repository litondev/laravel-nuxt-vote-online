<?php

namespace App\Http\Controllers\Admin\Action;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\{
    SigninRequest,
};

class AuthController extends Controller
{
    public function signin(SigninRequest $request){    	
        try{
    	   throw_if(!auth()->guard('admin')->attempt($request->validated()),new \Exception("Password atau email salah"));    

    	   return redirect("/admin");
        }catch(\Exception $e){
            \Log::channel("coex")->info($e->getMessage());

            return back()
            ->withInput()
            ->with([
                "fallback" => [
                    "status" => "failed",
                    "message" => "Password atau email salah"
                ]
            ]);
        }
    }

    public function logout(){
        auth()->guard('admin')->logout();

        return redirect("/signin");
    }
}
