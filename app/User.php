<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;    

    /**
     * The attributes that are mass assignable.
     * profileType = 2 empleador , 3 => empleado
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profileType', 'social_red'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    ##### RELATIONS ########################
    public function profile()//Employee
    {
        return $this->hasOne('App\EmployeeProfile');
    }

    public function employerProfile()
    {
        return $this->hasOne('App\EmployerProfile');
    }

    public function experiences()
    {
        return $this->hasMany('App\EmployeeExperience');
    }

    public function studies()
    {
        return $this->hasMany('App\EmployeeStudy');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }
}
