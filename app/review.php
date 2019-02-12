<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
       'user_id', 'reviwed_user', 'rating', 'body',
  ];

    public function users()
    {
        return $this->belongsTo('App/User');
    }

}
