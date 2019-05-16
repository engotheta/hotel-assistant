<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Handover extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to_id',
        'amount',
        'details',
        'user_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

}
