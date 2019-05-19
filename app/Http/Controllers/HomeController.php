<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Branch;
use App\User;
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
use App\Setting;
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

    public function homeParameters()
    {
        $themify_icons = new FontIcon;
        $hotel = Setting::where('name','hotel_name')->first();
        return [
          'hotel' => $hotel,
          'branches' => Branch::all(),
          'themify_icons' => $themify_icons->themifyIcons(),
          'members' => User::all(),
          'roles' => Role::all(),
          'functions' => new FunctionController,
          'view_items' => $this->getViewItems(),
          'admin_items' => $this->getAdminItems(),
          'home' => $hotel,
        ];
    }

    public function getAdminItems()
    {
        //
          $admin_items = [
                  [
                    'name' => 'settings' ,
                    'actions'=> [['name'=>'edit','link'=>'settings'],],
                    'target'=>'settingsModal' ],
                  [
                    'name' => 'branches',
                    'actions' => [
                            ['name'=>'add', 'link'=>'/branches/create'],
                            ['name'=>'edit'],
                            ['name'=>'delete']
                          ] ,
                    'target'=>'branchesModal' ],
              ];

          return $admin_items;

    }

    public function getViewItems()
    {
        $back_track_days = Setting::where('name', 'back_track_days')->first();
        $businessdays = Businessday::orderBy('id','desc')->take((int)$back_track_days->value)->get();
        $venue_bookings = Booking::where([['bookable_type','App/Venue'],
                ['due_date','>=',Carbon::now()->toDateTimeString()]])->get();

        $view_items = [
              [
                'name' => 'business days',
                'link' => '/businessdays/',
                'instance' => $businessdays, ],
              [
                'name' => 'unpaid loans',
                'link' => '/unpaid-loans/',
                'instance' => Loan::where('complete',false)->get(), ],
              [
                'name' => 'venue bookings',
                'link' => '/venue-bookings/',
                'instance' => $venue_bookings, ],
              [
                'name' => 'members',
                'link' => '/members/',
                'instance' => User::all(), ],
              [
                'name' => 'rooms',
                'link' => '/rooms/',
                'instance' => Room::all(), ],
              [
                'name' => 'drinks',
                'link' => '/drinks/',
                'instance' => Drink::all(), ],
              [
                'name' => 'foods',
                'link' => '/foods/',
                'instance' => Food::all(), ],
              [
                'name' => 'venues',
                'link' => '/venues/',
                'instance' => Venue::all(), ],
              [
                'name' => 'activities',
                'link' => '/activities/',
                'instance' => Activity::all(), ],
        ];

        return $view_items;
    }
}
