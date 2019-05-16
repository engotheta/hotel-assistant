<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
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
        'floor',
        'weekend_price',
        'weekday_price',
        'image',
        'count',
        'active',
        'capacity',
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

    public function bookings(){
      return $this->morphMany('App\Booking','bookable');
    }

    public function venues(){
      $start = 1;
      $step = 1;
      $end = 4;

      $venues = [];
      $i = 0; $n = 0;
      while( $i <= $end - $start)  {
        $venues[$n]= ['name'=>'hall'.($start+$i) ,'count' => mt_rand(0,300),'weekday_price' => 500000*mt_rand(1,3), 'weekend_price' => 800000*mt_rand(1,3),'fan' => mt_rand(1,10) % 2, 'ac' => mt_rand(1,10) % 2];
        $i += $step;
        $n++;
      }
      return $venues;
    }


}
