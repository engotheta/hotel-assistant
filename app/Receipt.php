<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    //

    protected $fillable = [
        'receiptient',
        'receiptient_id',
        'details',
        'transaction_id',
        'branch_id',
    ];


    public function pictures(){
      return $this->morphMany('App\Picture','picturable');
    }

}
