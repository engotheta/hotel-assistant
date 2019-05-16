<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
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
        'creator_id',
        'branch_id',
    ];


    public function getRouteKeyName(){
      return 'slug';
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
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

    public function foods(){
        $food = array(
          'mayai',
          'wali',
          'kuku',
          'ndizi',
          'samaki',
          'beef',
          'kuku choma',
          'mshikaki',
          'kuku kienyeji',
          'ugali',
          'chipsi',
        );

        $foods = [];
        for($n=0; $n<count($food); $n++)  {
          $foods[$n] = ['name'=>$food[$n], 'price' => 1000*mt_rand(1,10), 'stock' => mt_rand(0,50), 'count' => mt_rand(0,1000)];
        }
        return $foods;
    }
}
