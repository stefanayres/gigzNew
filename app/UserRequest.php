<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model
{

  public function users()
  {
      return $this->belongsTo('App/User');
  }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'requetsedUser_id', 'location', 'details', 'price', 'requestDate', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'requestingUser_id',
    ];

}
