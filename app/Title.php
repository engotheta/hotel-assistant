<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    //
    //
    protected $fillable = [
        'name',
        'details',
        'creator_id',
    ];

    public function users(){
      return $this->hasMany('App\User');
    }

    public function titles(){
          $categories = [
                  [ 'name' => 'bar service' , 'details' => 'offer services related to drinks'  ],
                  [ 'name' => 'room service' , 'details' => 'offers services related to room'  ],
                  [ 'name' => 'reception' , 'details' => 'frontliner in the room & venue services '  ],
                  [ 'name' => 'security' ,'details' => 'offer services related to property security'  ],
                  [ 'name' => 'cheff' ,'details' => 'prepares food and related items' ],
                  [ 'name' => 'chief cheff' , 'details' => 'frontliner in the food related issues' ],
                  [ 'name' => 'counter' ,'details' => 'oversees drinks stocks' ],
          ];

          return $categories;
      }
}
