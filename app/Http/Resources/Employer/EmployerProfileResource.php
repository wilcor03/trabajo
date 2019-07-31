<?php

namespace App\Http\Resources\Employer;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployerProfileResource extends JsonResource
{
  public function toArray($request)
  {        

      return [
          'id'                => $this->id,
          'socialReason'      => $this->socialReason,     
          'docType'           => collect(config('custom.docTypes'))->firstWhere('id', $this->docType),
          'doc'               => $this->doc,          
          'dv'                => $this->dv,
          'phone'             => $this->phone,
          'celPhone'          => $this->celPhone,
          'email'             => $this->email,
          'city'           => [
                                      'id'               => $this->city_id, 
                                      'name'             => $this->city->name,
                                      'departament_name' => $this->city->departament->name 
                                  ],
          'sectors'        => $this->setSectors($this->sectors)

      ];
  }

  private function setSectors($sectors){
    $data = [];
    foreach($sectors as $s){
      array_push($data, [
        'id'    => $s->id,
        'name'  => $s->name
      ]);  
    }
    return $data;    
  }
}
