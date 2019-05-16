<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Businessday extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'sales',
        'paid_loans',
        'bookings',
        'pettycash',
        'purchases',
        'expenditures',
        'complete',
        'loans',
        'loss',
        'user_id',
        'creator_id',
        'department_id',
        'branch_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function pictures(){
      return $this->morphMany('App\Picture','picturable');
    }

}
