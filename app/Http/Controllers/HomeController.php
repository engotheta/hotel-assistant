<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\FontIcon;
use App\Room;
use App\Drink;
use App\Food;
use App\Role;
use App\Venue;
use App\Activity;
use App\Businessday;
use App\Loan;
use App\Booking;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home',$this->homeParameters());
    }

    public function homeParameters(){
      $hotel = DB::table('settings')->where('name', 'hotel_name')->first();
      $back_track_days = DB::table('settings')->where('name', 'back_track_days')->first();

      $themify_icons = new FontIcon;
      $branches = DB::table('branches')->get();

      $members = DB::table('users')->get();
      $rooms = Room::all();
      $drinks = Drink::all();
      $foods = Food::all();
      $venues = Venue::all();
      $activities = Activity::all();

      $businessdays = Businessday::orderBy('id','desc')->take((int)$back_track_days->value)->get();
      $unpaid_loans = Loan::where('complete',false)->get();
      $venue_bookings = Booking::where([['bookable_type','App/Venue'],
              ['due_date','>=',Carbon::now()->toDateTimeString()]])->get();

      return [
        'hotel' =>  $hotel,
        'branches' => $branches ,
        'themify_icons' => $themify_icons->themifyIcons() ,
        'members' => $members,
        'roles' => Role::all(),
        'rooms' => $rooms,
        'functions' => new FunctionController,
        'drinks' => $drinks,
        'foods' => $foods,
        'venues' => $venues,
        'activities' => $activities,
        'businessdays' => $businessdays,
        'unpaid_loans' => $unpaid_loans,
        'venue_bookings' => $venue_bookings,
      ];
    }
}
