<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CityResource;
use Illuminate\Support\Arr;

use App\City;
use App\Sector;
use App\Departament;

use Mailgun\Mailgun;

class SettingController extends Controller
{
  public function sendEmail(){
    
  }

  public function getCitiesWithDeps(){
  	$cities = City::orderBy('name')->get();
  	return CityResource::collection($cities);	
  }

  public function getDocTypes(){  	
  	return config('custom.docTypes');
  }

  public function getSectors(){
  	return response()->json(Sector::get());
  }

  public function getCitiesAndDeps(){
  	$deps 	= collect(Departament::orderBy('name')->get(['id', 'name']))
  						->map(function($item){
  							return [
  								'id' 		=> $item->id,
  								'name'	=> $item->name,
  								'type'  => 'dep'
  							];
  						});
  						

  	$cities = collect(City::orderBy('name')->get())
  						->map(function($item){
  							return [
  								'id' 		=> $item->id,
  								'name'	=> $item->name,
  								'type'  => 'city',
  								'departament_name' => $item->departament->name
  							];
  						});

  	$allData = Arr::collapse([$deps, $cities]);
  	return $allData;
  }
}
