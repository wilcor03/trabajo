<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\CategoryResource;

use App\Category;
use App\User;

class EmployeeCategoryController extends Controller
{
    public function list(){ 
    	$user = auth()->user();
    	$catList = Category::get(['id', 'name']);    	
    	$catListSelected = collect($user->categories);
    	$selectedIds = array_pluck($catListSelected, 'id');
    	
    	$catList->map(function($item, $key) use ($selectedIds){
    		if(in_array($item->id, $selectedIds)){
    			$item->selected = true;
    		} else {
    			$item->selected = false;
    		}
    	});    	
    	return CategoryResource::collection($catList);
    }

    public function attach(Request $r){
      $r->validate([
        'id'        => 'required|exists:categories,id',        
      ]);

    	$user = auth()->user();    	
    	$saved = $user->categories()->toggle($r->id);
    	if(count($saved['attached'])){
    		$resp = true;
    	}else{
    		$resp = false;
    	}

    	return response()->json($resp, 200);    	
    }

    public function myCategories(){
    	$user = auth()->user();
    	$cats = $user->categories;
    	return CategoryResource::collection($cats);
    }
}
