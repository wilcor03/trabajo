<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   $city = $this->profile ? $this->profile->city : null;
        return [
            'name'    => $this->name,
            'email'   => $this->email,
            'celPhone'=> $this->profile ? $this->profile->celPhone : '',
            'birthDay'=> $this->profile ? $this->profile->birthDay : '',
            'description' => $this->profile ? $this->profile->description: '',
            'city' => $city ? $city->load('departament') : ''
        ];
        //return parent::toArray($request);
    }
}
