<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'company'   => $this->company,
            'appointment'=>$this->appointment,
            'details'   => $this->details,
            'experience_code' => collect(config('custom.experience_codes'))->firstWhere('id', $this->experience_code),
        ];
    }
}
