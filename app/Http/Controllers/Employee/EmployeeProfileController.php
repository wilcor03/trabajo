<?php

namespace App\Http\Controllers\Employee;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Resources\ProfileResource;

use App\User;

class EmployeeProfileController extends Controller
{
	private $actualUser;	

  public function store(Request $r)
  { 
    $r->validate([
      'name'        => 'required|string|max:100|min:10',
      'email'       => 'required|email|max:100|min:10',
      'birthDay'    => 'required|date',
      'celPhone'    => 'required|max:100',
      'description' => 'required|max:1000',
      'city_id'     => 'required|exists:cities,id'
    ]);

  	$user = auth()->user();//$this->actualUser;
  	$user->name = $r->name;
  
  	if($user->save())
  	{
  		if(!$user->profile)
  		{
  			$pro = $user->profile()->create($r->except(['name', 'email']));	
  		}
  		else
  		{  		
  			$pro = $user->profile;
  			$pro->fill($r->except(['name', 'email']));
  			$pro->save();
  		}
  		$updatedUser = $pro->user;
  	}

  	return new ProfileResource($updatedUser);
  }

  public function myProfile()
  { 
    $this->actualUser = auth()->user();
  	if($this->actualUser->profile)
  	{
  		return new ProfileResource($this->actualUser);	
  	}  	
    return new ProfileResource($this->actualUser);  
  }
}
