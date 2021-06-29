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


Route::group(["namespace" => "User"],function(){
	Route::post("/signin","AuthController@signin");
	
	Route::group(["middleware" => "jwt-refresh"],function(){
		Route::post("/refresh","AuthController@refresh");
	});

	Route::group(["middleware" => "jwt"],function(){
		Route::post("/logout","AuthController@logout");
		Route::get("/me","AuthController@me");
	});
});