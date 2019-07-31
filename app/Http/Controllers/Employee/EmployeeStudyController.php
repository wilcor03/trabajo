<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\StudyResource;

use App\EmployeeStudy;
use App\User;

class EmployeeStudyController extends Controller
{
  public function list()
  {
    $user = auth()->user();
  	$items = $user->studies()->get(['id', 'institution', 'title', 'time']);
  	return StudyResource::collection($items);
  }

  public function store(Request $r){
    $r->validate([
      'institution' => 'required|between:3,100|string',
      'title'       => 'required|between:3,100|string',
      'time'        => 'required|between:1,50|string'              
    ]);

  	$user = auth()->user();  	    

  	if($user->studies()->whereId($r->id)->exists())
  	{
  		$es = $user->studies()->whereId($r->id)->first();
  		$es->fill($r->all());
	  	$es->user()->associate($user);
	  	$es->save();      
  	}
  	else
  	{
  		$es = new EmployeeStudy;
	  	$es->fill($r->all());
	  	$es->user()->associate($user);
	  	$es->save();      
  	}
  	
  	return new StudyResource($es);
  }

  public function delete($item_id){  	
  	$user = auth()->user();
  	$es = $user->studies()->where('id', $item_id)->first();
    dd($es);
  	if($es->delete()){
      return response()->json(true, 200);  
    }
    return response()->json(false, 500);    	
  }
}
