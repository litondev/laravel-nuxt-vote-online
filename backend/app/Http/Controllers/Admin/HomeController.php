<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
    	echo "<a href='".route("admin.action.logout")."'>Keluar</a>";    	    	
    	echo "<br/>";
    	return "Hello  Admin";
    }
}
