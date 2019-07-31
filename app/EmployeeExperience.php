<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeExperience extends Model
{
    protected $table = 'employee_experiences';
    protected $fillable = ['company', 'appointment', 'experience_code', 'details'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
