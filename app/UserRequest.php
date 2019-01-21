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
         'requestingUser_id', 'requetsedUser_id', 'location', 'details', 'price', 'requestDate', 'status',
    ];

    

}
