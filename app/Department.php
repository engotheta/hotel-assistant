<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
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
        'image',
        'slug',
        'contact_person_id',
        'branch_id',
        'creator_id',

    ];

    public function getRouteKeyName(){
      return 'slug';
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function users(){
      return $this->hasMany('App\User');
    }

    public function members(){
      return $this->hasMany('App\User');
    }

    public function loans(){
      return $this->hasMany('App\Loan');
    }

    public function businessdays(){
      return $this->hasMany('App\Businessday');
    }

    public function services(){
      return $this->belongsToMany('App\Service','department_service');
    }

    public function pictures(){
      return $this->morphMany('App\Picture','picturable');
    }

    public function departments(){
          $categories = [
                  [ 'name' => 'bar', 'details' => 'deals with drinks business', 'services'=>['drinks']  ],
                  [ 'name' => 'accomodation' ,'details' => 'deals with rooms and venues business' , 'services'=>['rooms','venues'] ],
                  [ 'name' => 'kitchen' , 'details' => 'deals with matters and business related to food', 'services'=>['foods']   ],
          ];

          return $categories;
      }


}
