<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\ExperienceResource;

use App\EmployeeExperience;
use App\User;

class EmployeeExperienceController extends Controller
{
  public function store(Request $r)
  { 
    $r->validate([
      'company'        => 'required|between:3,100|string',
      'appointment'    => 'required|between:3,100|string',
      'experience_code'=> 'required|between:1,4|numeric',        
      'details'        => 'required|between:20,1000|string',
    ]);

  	$user = auth()->user();  	

  	if($user->experiences()->whereId($r->id)->exists())
  	{
  		$ex = $user->experiences()->whereId($r->id)->first();
  		$ex->fill($r->all());
	  	$ex->user()->associate($user);
	  	$ex->save();
  	}
  	else
  	{
  		$ex = new EmployeeExperience;
	  	$ex->fill($r->all());
	  	$ex->user()->associate($user);
	  	$ex->save();
  	}
  	
  	return new ExperienceResource($ex);	
  }

  public function experienceList()
  {
  	$user = auth()->user();
  	$data = $user->load('experiences');  	
  	return ExperienceResource::collection($data->experiences);
  }

  public function experienceOptions()
  {
  	$ops = [
  		['id' => 1, 'name' => 'Menos de un año'],
  		['id' => 2, 'name' => 'Entre uno y dos años'],
  		['id' => 3, 'name' => 'Entre dos y tres años'],
  		['id' => 4, 'name' => 'Mas de tres años']
  	];

  	return response()->json($ops, 200);
  }

  public function delete($item_id){  	
  	$user = auth()->user();
  	$ex = $user->experiences()->whereId($item_id)->first();
  	$ex->delete();
  	return response()->json(true, 200);
  }
}
