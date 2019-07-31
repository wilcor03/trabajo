<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\Employer\EmployerProfileResource;

use App\User;
use App\EmployerProfile;

class EmployerProfileController extends Controller
{
  public function getProfile(){
    
  	$user = auth()->user();

  	if($user->employerProfile)
  	return new EmployerProfileResource($user->employerProfile);  	
  }

  public function store(Request $r)
  {
    $r->validate([
      'socialReason'=> 'required|string|max:100|min:3',
      'docType'     => 'required|numeric|max:9',
      'doc'         => 'required|numeric|digits_between:3,15',
      'dv'          => 'required|numeric|digits_between:1,2',
      'phone'       => 'numeric|digits_between:7,10',
      'celphone'    => 'numeric|digits:10',
      'email'       => 'required|email',
      'city_id'     => 'required|exists:cities,id'      
    ]);
  	
    $user = auth()->user();

  	$pro = $user->employerProfile;  	
  	if(!$pro){
  		$pro = new EmployerProfile;
  	}
	
  	$pro->fill($r->all());
  	$pro->user()->associate($user);
  	if($pro->save())
  	{
  		$pro->sectors()->sync($r->sectors);
  		return new EmployerProfileResource($pro);  		
  	}
  	
  }
}
