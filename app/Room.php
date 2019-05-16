<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
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
        'slug',
        'price',
        'holiday_price',
        'floor',
        'image',
        'count',
        'active',
        'booked',
        'ac',
        'fan',
        'creator_id',
        'room_type_id',
        'branch_id',
    ];

    public function getRouteKeyName(){
      return 'slug';
    }

    public function branch(){
      return $this->belongsTo('App\Branch');
    }

    public function roomType(){
      return $this->belongsTo('App\RoomType');
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

    public function rooms(){
      $start = 600;
      $step = 1;
      $end = 650;

      $rooms = [];
      $i = 0; $n = 0;
      while( $i <= $end - $start)  {
        $rooms[$n] = ['name'=>($i+$start), 'price' => 5000*mt_rand(3,10), 'fan' => mt_rand(1,10) % 2, 'ac' => mt_rand(1,10) % 2, 'count' => mt_rand(0,300)];
        $i += $step;
        $n++;
      }
      return $rooms;
    }


}
