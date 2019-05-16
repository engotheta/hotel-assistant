<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
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
        'details',
        'price',
        'stock',
        'count',
        'crate_price',
        'single_price',
        'creator_id',
        'crate_size_id',
        'drink_type_id',
        'branch_id',
    ];

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function getRouteKeyName(){
      return 'slug';
    }

    public function crateSize(){
      return $this->belongsTo('App\CrateSize');
    }

    public function drinkType(){
      return $this->belongsTo('App\DrinkType');
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

    public function drinks(){
        $drink = array(
          'pepsi',
          'coca cola',
          'azam mango',
          'azam tropical',
          'grants bapa',
          'grants kubwa',
          'heinesy',
          'balimi',
          'grand malta',
          'redbull',
          'bavaria',
          'konyagi bapa',
          'konyagi kubwa',
          'heinkein',
          'castle lite',
          'serenget lite'
        );

        $drinks = [];
        for($n=0; $n<count($drink); $n++)  {
          $drinks[$n] = ['name'=>$drink[$n], 'price' => 1000*mt_rand(1,10), 'stock' => mt_rand(0,200), 'count' => mt_rand(0,2000)];
        }
        return $drinks;
    }


}
