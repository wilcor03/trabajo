<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
    	return view('app.index');
    }

    public function authUser(Request $r){
    	return $r->user();    	
    }

    public function setProfileTypeField(Request $r){
    	$r->validate([
    		'profileType' => ['required', 'in:2,3']
    	]);
    	$user = $r->user();

    	if($user->profileType != null){
    		return response()->json('error!', 401);
    	}

    	$user->profileType = $r->profileType;
    	if($user->save()){
    		return response()->json($user, 200);
    	}
    }

    public function allCategories(){
      return Category::all();
    }
}
