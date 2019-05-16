<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
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
        'icon',
        'creator_id',
        'image',
    ];

    public function rooms(){
      return $this->hasMany('App\Room');
    }

    public function roomTypes(){
          $categories = [
                  [ 'name' => 'double' , 'details' =>  'has two beds' ],
                  [ 'name' => 'suite', 'details' =>  'has a bigger bed with a living room' ],
          ];

          return $categories;
      }
}
