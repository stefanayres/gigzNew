<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'requestingUser_id', 'requetsedUser_id', 'location', 'details', 'price', 'requestDate', 'status',
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'requestingUser_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'requestedUser_id');
    }

    public function userDetails()
    {
       return $this->hasOne('App\userDetail');
    }


}
