<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Branch extends Model
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
        'floors',
        'creator_id',
        'contact_person_id',
        'address_id',
    ];

    public function getRouteKeyName(){
      return 'slug';
    }

    public function address(){
    	return $this->belongsTo('App\Address');
    }

    public function department($department){
      return   $dep = $this->departments->where('name',$department)->first();
    }

    public function pictures(){
    	return $this->morphMany('App\Picture','picturable');
    }

    public function departments(){
    	return $this->hasMany('App\Department');
    }

    public function users(){
    	return $this->hasMany('App\User');
    }

    public function members(){
      return $this->hasMany('App\User');
    }

    public function rooms(){
    	return $this->hasMany('App\Room');
    }

    public function venues(){
      return $this->hasMany('App\Venue');
    }

    public function drinks(){
    	return $this->hasMany('App\Drink');
    }

    public function foods(){
    	return $this->hasMany('App\Food');
    }

    public function activities(){
    	return $this->hasMany('App\Activity');
    }

    public function businessdays(){
    	return $this->hasMany('App\Businessday');
    }

    public function transactions(){
    	return $this->hasMany('App\Transaction');
    }

    public function venueBookings(){
      return  Booking::where([
              ['bookable_type','App/Venue'],
              ['due_date','>=',Carbon::now()->toDateTimeString()],
              ['branch_id',$this->id] ])->get();
    }

    public function unpaidLoans(){
      return Loan::where([['complete',false],['branch_id',$this->id]])->get();
    }

    public function recentBusinessdays(){
      $back_track_days = Setting::where('name', 'back_track_days')->first();
      return Businessday::where('branch_id',$this->id)->orderBy('id','desc')->take((int)$back_track_days->value)->get();
    }
}
