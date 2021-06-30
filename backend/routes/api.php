<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(["namespace" => "User","middleware" => "maintaince"],function(){
	Route::get("/check",function(){
		return response()->json([
			"status" => "Success",
			"message" => "Ok"
		]);
	});
	
	Route::post("/signin","AuthController@signin");
	Route::post("/signup","AuthController@signup");
	
	Route::group(["middleware" => "jwt-refresh"],function(){
		Route::post("/refresh","AuthController@refresh");
	});

	Route::group(["middleware" => "jwt"],function(){
		Route::post("/logout","AuthController@logout");
		Route::get("/me","AuthController@me");
		
		Route::apiResource("user-vote","UserVoteController");

		Route::group(["prefix" => "profil"],function(){
			Route::post("/upload","ProfilController@upload");
			Route::post("/update","ProfilController@update");
		});
	});
});