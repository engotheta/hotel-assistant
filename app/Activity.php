<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'price',
        'details',
        'creator_id',
        'contact_person_id',
        'branch_id',
    ];

    public function getRouteKeyName(){
      return 'slug';
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function transactionTypes(){
      return $this->belongsToMany('App\TransactionType','activity_transaction_type');
    }

    public function transactions(){
      return $this->hasMany('App\Transation');
    }

    public function businessdays(){
      return $this->hasMany('App\Businessday');
    }


    public function pictures(){
      return $this->morphMany('App\Picture','picturable');
    }

    public function remarks(){
      return $this->morphMany('App\Remark','remarkable');
    }

    public function loans(){
      return $this->morphMany('App\Loan','loanable');
    }

    public function activities(){
          $categories = [
                  [ 'name' => 'pool table', 'price' => 200 , 'details' => 'ploting ball to holes on a table platform', 'count' => mt_rand(0,500) ],
                  [ 'name' => 'dats' ,  'price' => 500 ,'details' => 'throwing sharp pointed rod to a marked board', 'count' => mt_rand(0,500)  ],
                  [ 'name' => 'dice' , 'price' => 200 , 'details' => 'rolling dice, probability driven' ,'count' => mt_rand(0,500)  ],
          ];

          return $categories;
      }
}
