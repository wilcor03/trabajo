<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerOffer extends Model
{
	/*
		state => null = en estudio, 1 = aprobado 2 = denegado
	*/
  protected $fillable = [
  	'vacancyName', 'description','publicationStart', 'publicationEnd',
  	'contractType', 'salary', 'visible', 'state', 'contactPhone', 'contactCellPhone','contactEmail'
	];

	protected $table = 'employer_offers';

	#### RELATIONS #################
	public function cities(){
		return $this->belongsToMany('App\City');
	}

	public function departaments(){
		return $this->belongsToMany('App\Departament');
	}

	public function categories(){
		return $this->belongsToMany('App\Category');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}
}
