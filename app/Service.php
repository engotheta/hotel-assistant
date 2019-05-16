<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = [
        'name',
        'details',
        'creator_id',
    ];

    public function services(){
          $categories = [
                  [ 'name' => 'rooms' ,  'details' => 'room service'  ],
                  [ 'name' => 'venues' , 'details' => 'venue service for ceremonies, events and functions'  ],
                  [ 'name' => 'foods' ,  'details' => 'food of different types and style'  ],
                  [ 'name' => 'drinks' , 'details' => 'drink service, with different variaties' ],
          ];

          return $categories;
      }

      public function departments(){
        return $this->belongsToMany('App\Derpartment','department_service');
      }

      public function transactionTypes(){
        return $this->belongsToMany('App\TransactionType','service_transaction_type') ;
      }
}
