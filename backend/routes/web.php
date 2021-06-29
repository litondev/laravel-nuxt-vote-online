<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["namespace" => "Admin"],function(){
	Route::get("/signin","AuthController@signin")->name("admin.signin");

	Route::group(["namespace" => "Action"],function(){
		Route::post("/signin","AuthController@signin")->name("admin.action.signin");

		Route::group(["middleware" => "is-admin","prefix" => "admin"],function(){
			Route::get("/logout","AuthController@logout")->name("admin.action.logout");
		});
	});

	Route::group(["middleware" => "is-admin","prefix" => "admin"],function(){
		Route::get("/","HomeController@index")->name("admin.index");
	});
});