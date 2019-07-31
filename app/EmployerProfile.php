<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model
{
    protected $table 	= 'employer_profiles';
    protected $fillable = ['socialReason', 'docType', 'doc', 'dv', 'phone', 'celPhone', 'email', 'city_id'];

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function city(){
    	return $this->belongsTo('App\City');
    }

    public function sectors(){
    	return $this->belongsToMany('App\Sector');
    }
}