<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remark',
        'solved',
        'remarkable_type',
        'remarkable_id',
        'businessday_id',
        'creator_id',
        'branch_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function picturable(){
      return $this-> morphTo();
    }

}
