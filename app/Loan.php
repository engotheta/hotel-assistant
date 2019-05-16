<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'details',
        'amount',
        'paid',
        'complete',
        'client',
        'loanable_type',
        'loanable_id',
        'user_id',
        'businessday_id',
        'department_id',
        'activity_id',
        'branch_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function department(){
      return $this->belongsTo('App\Department');
    }

}
