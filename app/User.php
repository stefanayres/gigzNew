<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
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
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function userRequest()
    {
      return $this->hasMany('App\UserRequest', 'requestedUser_id');
    }
    public function userRequests()
    {
      return $this->hasMany('App\UserRequest', 'requestingUser_id');
    }

    public function userDetails()
    {
       return $this->hasOne('App\userDetail');
    }

    public function review()
    {
      return $this->hasMany('App\review');
    }

    public function favourite()
    {
      return $this->hasMany('App\favourite', 'favourite_id');
    }

}
