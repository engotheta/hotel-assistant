<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'details',
        'attendants',
        'food_budget',
        'drinks_budget',
        'food_paid',
        'drinks_paid',
        'details',
        'complete',
        'booking_id',
        'venue_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }
    
    public function venue(){
      return $this->belongsTo('App\Venue');
    }

}
