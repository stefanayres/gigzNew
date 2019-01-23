<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userDetail extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'user_id', 'bios', 'avatarURL', 'contactNumber', 'locationId',
  ];


  public function users()
    {
    	return $this->belongsTo('App\User');
    }

}
