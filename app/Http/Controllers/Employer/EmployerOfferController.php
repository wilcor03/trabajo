<?php

namespace App\Http\Controllers\Employer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Employer\EmployerOfferResource;

use Illuminate\Validation\Rule;

use App\EmployerOffer;
use App\User;

use App\Notifications\AdminNewOffer;

class EmployerOfferController extends Controller
{
  public function index(){
    $offers = EmployerOffer::orderBy('updated_at', 'desc')
                            ->where('user_id', auth()->id()) 
                            ->with('departaments')
                            ->with('cities')
                            ->with('categories')
                            ->paginate(10);

    if($offers->count()){
      return EmployerOfferResource::collection($offers);  
    }    
  }

  public function store(Request $r){  	
    //dd($r->all());
    $r->validate([      
      "vacancyName" => "required|string|max:100|min:10",
      "description" => "required|string|max:1500|min:100",
      "publicationStart" => "required|date|before_or_equal:publicationEnd",
      "publicationEnd" => 'required|date|after_or_equal:publicationStart',
      "contractType" => 'required|numeric|max:4',
      "contactEmail" => "required|email",
      "contactPhone" => 'nullable|numeric|digits_between:7,10',
      "contactCellPhone" => 'required|numeric|digits:10',
      "salary" => 'required|numeric|max:99999999',
      "visible" => 'required|numeric|max:2',
      "coverage" => ''
    ]);
    //dd('paso');


  	$of = "";
  	if($r->has('id') && is_numeric($r->id)){
  		$of = EmployerOffer::where('id', $r->id)
                          ->where('user_id', auth()->id())
                          ->first();

  		$of->fill($r->all());
      $of->state = null;      
      $of->user()->associate(auth()->user());
  		$of->save();
  	} else {
  		$of = new EmployerOffer;
      $of->fill($r->all());
      $of->user()->associate(auth()->user());
      $of->save();	

      $user = User::where('profileType', 1)->first();
      $user->notify(new AdminNewOffer($of));
  	} 	
  	
    $data = $of->load('cities', 'departaments', 'categories');    
  	return response()->json($data, 200);
  }

  public function show($offer){
    $offer = EmployerOffer::where('id', $offer)
                          ->with('departaments')
                          ->with('cities')
                          ->with('categories')
                          ->first();

    return response()->json($offer);
  }

  public function edit($offer){
    $offer = EmployerOffer::where('id', $offer)
                          ->with('departaments')
                          ->with('cities')
                          ->with('categories')
                          ->first();

    return response()->json($offer); 
  }

  public function attachCitiesAndDeps(Request $r){
    

    $r->validate([
      "coverage" => 'required|numeric|max:2',
      'offerID'  => 'required|exists:employer_offers,id',
      'cityIDs'  => Rule::requiredIf(function () use ($r) {
        if($r->coverage == 2 && !$r->depIDs){
          return true;
        }
      }),
      'depIDs'  => Rule::requiredIf(function () use ($r) {
        if($r->coverage == 2 && !$r->cityIDs){
          return true;  
        }
      }),
    ]);
    

		$offer = EmployerOffer::where('id', $r->offerID)
                          ->where('user_id', auth()->id())
                          ->first();

		if($r->coverage == 1){
			$offer->coverage = $r->coverage;
			$offer->save();
			$offer->cities()->detach();
			$offer->departaments()->detach();
			return response()->json(true, 200);
		}
		
		if($r->has('depIDs')){
			$offer->cities()->sync($r->cityIDs);
		}	

		if($r->has('depIDs')){
			$offer->departaments()->sync($r->depIDs);
		}

		$offer->coverage = $r->coverage;
		if($offer->save()){
      return response()->json(true, 200);  
    }

    return response()->json(false, 404);		
  }

  public function attachCategory(Request $r){//dd($r->all());    
    $r->validate([
      'offerID' => 'required',
        Rule::exists('employer_offers')->where(function ($query) use ($r){
          $query->where('user_id', $r->offerID)
                ->where('user_id', auth()->id());
        }),
      'selectedItems.*' => 'required|distinct|exists:categories,id'
    ]);

  	$offer = EmployerOffer::where('id', $r->offerID)
                          ->where('user_id', auth()->id())
                          ->first();

  	$offer->categories()->sync($r->selectedItems);

  	return response()->json(true, 200);
  }

  public function destroy($id){
    $offer = EmployerOffer::where('id', $id)
                          ->where('user_id', auth()->id())
                          ->first();
                          return response()->json(['success' => true], 200);
                          
    if($offer->delete()){
      return response()->json(['success' => true], 200);
    }    
    return response()->json(['success' => false], 404);
  }
}
