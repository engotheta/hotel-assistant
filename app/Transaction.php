<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'quantity',
        'total',
        'details',
        'transactionable_type',
        'transactionable_id',
        'transactionType_id',
        'businessday_id',
        'department_id',
        'activity_id',
        'branch_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

}
