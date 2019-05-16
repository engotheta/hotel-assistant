<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $fillable = [
        'client',
        'email',
        'phone',
        'details',
        'due_date',
        'paid',
        'complete',
        'bookable_type',
        'bookable_id',
        'businessday_id',
        'branch_id',
    ];

    public function bookable(){
      return $this-> morphTo();
    }
    public function scopeFuture(){
      return $query->where('due_date','>=',Carbon::now()->toDateTimeString());
    }

    public function businessday(){
      return $this->belongsTo('App\Businessday');
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
    }



}
