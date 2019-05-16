<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DrinkType extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'details',
        'creator_id',
    ];

    public function drinks(){
      return $this->hasMany('App\Drink');
    }

    public function drinkTypes(){
          $categories = [
                  [ 'name' => 'water' ,   'details' => 'water'],
                  [ 'name' => 'juice' ,   'details' => 'juice'],
                  [ 'name' => 'beverage', 'details' => 'non alcoholic soft drinks which are not in soda' ],
                  [ 'name' => 'soda' ,    'details' => 'drinks from pepsi or coca colar family'],
                  [ 'name' => 'beer' ,    'details' => 'beers that are imported'],
                  [ 'name' => 'local beer', 'details' => 'beers that a procuded in the country '],
                  [ 'name' => 'spirit',   'details' => 'vodka family drinks' ],
                  [ 'name' => 'whiskey',  'details' => 'whiskey family drinks' ],
          ];

          return $categories;
      }

      public function pictures(){
        return $this->morphMany('App\Picture','picturable');
      }

}
