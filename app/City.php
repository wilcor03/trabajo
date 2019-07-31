<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public function departament(){
    	return $this->belongsTo('App\Departament');
    }
}
