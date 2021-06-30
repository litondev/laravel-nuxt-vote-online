<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\{
	ProfilUploadRequest,
	ProfilUpdateRequest
};
use DB;
use App\Uploads\UploadProfilPhoto;

class ProfilController extends Controller
{
    public function upload(ProfilUploadRequest $request){    	
    	try{
    		DB::beginTransaction();

    		$oldPhoto = auth()->user()->photo_original;

        	auth()->user()->update([
          		"photo" => UploadProfilPhoto::upload()
        	]);

			UploadProfilPhoto::delete($oldPhoto);

    		DB::commit();

    		return response()->json([
				"status" => "Success",
				"message" => "Berhasil Upload"
    		]);
    	}catch(\Exception $e){
    		DB::rollback();

    		\Log::channel("coex")->info($e->getMessage());

    		return response()->json([			   
    			"status" => "Failed",
    			"message" => "Terjadi Kesalahan"
    		],500);
    	}    
    }

    public function update(ProfilUpdateRequest $request){
    	try{
            DB::beginTransaction();

            throw_if(!\Hash::check($request->password_confirm,auth()->user()->password),new \Exception("Password Konfirmasi Salah"));

            auth()->user()->update($request->password ? $request->only("username","email","password") : $request->only("username","email"));            

            DB::commit();
            
            return response()->json([
                "status" => "Success",
                "message" => "Berhasil Update"
            ]);
        }catch(\Exception $e){
            DB::rollback();

            \Log::channel("coex")->info($e->getMessage());

            return response()->json([
                 "status" => "Failed",
                 "message" => $e->getMessage() !== "Password Konfirmasi Salah" ? "Terjadi Kesalahan" : "Password Konfirmasi Salah"
            ],500);
        }
    }
}
