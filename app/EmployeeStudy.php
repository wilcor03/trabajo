<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeStudy extends Model
{
    protected $fillable = ['title', 'institution', 'time'];

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
