<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CrateSize extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'size',
        'details',
        'creator_id',
    ];

    public function drinks(){
      return $this->hasMany('App\Drink');
    }

    public function crateSizes(){
          $categories = [
                  [ 'size' => 6 ],
                  [ 'size' => 12 ],
                  [ 'size' => 20 ],
                  [ 'size' => 24 ],
          ];

          return $categories;
      }
}
