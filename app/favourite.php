<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class favourite extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'users_id', 'favourite_id', 'fav',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
      'id',
  ];

  public function users()
  {
      return $this->belongsTo('App\User');
  }

}
