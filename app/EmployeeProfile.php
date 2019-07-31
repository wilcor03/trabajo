<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeProfile extends Model
{
    protected $table = 'employee_profiles';
    protected $fillable = ['celPhone', 'birthDay', 'description', 'city_id'];

    ###### RELATIONS ##############
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function city(){
    	return $this->belongsTo('App\City');
    }
}
