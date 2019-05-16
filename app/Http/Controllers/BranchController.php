<?php

namespace App\Http\Controllers;

use App\Branch;
use App\FontIcon;
use App\Picture;
use App\Address;
use App\Service;
use App\Businessday;
use App\TransactionType;
use App\Role;
use App\Title;
use App\Loan;
use App\Booking;
use App\CrateSize;
use App\DrinkType;
use App\RoomType;
use Carbon\Carbon;
use App\Http\Controllers\PictureController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{

      public function __construct()
      {
          $this->middleware('auth');
      }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $homeController = new HomeController;
        $parameters = $homeController->homeParameters();
        return view('pages.add.add_branch',$parameters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $branch = new Branch;

        $branch->name = $request->name;
        $branch->slug = str_replace(" ","-",trim($request->name));
        $branch->floors = $request->floors;
        $branch->details = filled($request->details) ?  $request->details : null ;
        $branch->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;

        $result = Address::where('name', $request->address)->first();

        if(!$result){
          $address = new Address;
          $address->name = $request->address;
          $address->save();
        }else{
          $address = $result;
        }

        try{
          $address->branches()->save($branch);

          $pic = new PictureController;
          $pic->storeAndAttach($request,$branch,'A picture for '.$branch->name.' branch');

          return redirect('/home')->with('success', 'the '.$branch->name.' branch has been successfully added');

        } catch(\Illuminate\Database\QueryException $e){
            return back()->with('success', 'the '.$branch->name.' branch could not be added, check for duplications');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
        $parameters = $this->branchParameters($branch);
        return view('branch',$parameters);
    }

    public function showToDelete(Branch $branch){
      //
      $homeController = new HomeController;
      $parameters = $homeController->homeParameters();
      $parameters['branch'] = $branch;

      return view('pages.delete.delete_branch',$parameters);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit(Branch $branch)
    {
        //
        $homeController = new HomeController;
        $parameters = $homeController->homeParameters();
        $parameters['branch'] = $branch;
        return view('pages.edit.edit_branch',$parameters);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Branch $branch)
    {
        //
        $name = $branch->name ;
        $branch->name = $request->name;
        $branch->floors = $request->floors;
        $branch->details = filled($request->details) ?  $request->details : null ;
        $branch->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;

        $result = Address::where('name', $request->address)->first();

        if(!$result){
          $address = new Address;
          $address->name = $request->address;
          $address->save();
        }else{
          $address = $result;
        }

        try{
            $branch->slug = str_replace(" ","-",trim($branch->name));
            $address->branches()->save($branch);
            $pic = new PictureController;
            $pic->storeAndAttach($request,$branch,'A picture for '.$branch->name.' branch');
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success', 'the '.$branch->name.' branch could not be edited');
        }

        if($name!=$branch->name) return redirect('/home')->with('success', 'the '.$branch->name.' branch has been successfully edited');

        return back()->with('success', 'the '.$branch->name.' branch has been successfully edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Branch $branch)
    {
        //
        $name = $branch->name;

        try{
          $branch->delete();
        }catch(\Illuminate\Database\QueryException $e){
          return redirect('home')->with('error','the '.$name. ' cannot be deleted, since it is in use');
        }

        return redirect('home')->with('success','the '.$name. ' branch has been deleted successfully');
    }

    public function branchParameters(Branch $branch){
      $hotel = DB::table('settings')->where('name', 'hotel_name')->first();
      $back_track_days = DB::table('settings')->where('name', 'back_track_days')->first();
      $transaction_types = TransactionType::all();
      $roles = Role::all();
      $titles = Title::all();
      $services = Service::all();
      $room_types = RoomType::all();
      $drink_types = DrinkType::all();
      $crate_sizes = CrateSize::all();
      $themify_icons = new FontIcon;
      $functions = new FunctionController;

      $departments = $branch->departments;
      $members = $branch->users;
      $rooms = $branch->rooms;
      $drinks = $branch->drinks;
      $foods = $branch->foods;
      $venues = $branch->venues;
      $activities = $branch->activities;

      $businessdays = Businessday::where('branch_id','=',$branch->id)->orderBy('id','desc')->take((int)$back_track_days->value)->get();
      $unpaid_loans = Loan::where([['complete',false],['branch_id',$branch->id]])->get();
      $venue_bookings = Booking::where([
              ['bookable_type','App/Venue'],
              ['due_date','>=',Carbon::now()->toDateTimeString()],
              ['branch_id',$branch->id]  ])->get();



      return [
        'hotel' =>  $hotel,
        'functions'=>$functions,
        'roles' =>  $roles,
        'titles' =>  $titles,
        'services' =>  $services,
        'room_types' =>  $room_types,
        'drink_types' =>  $drink_types,
        'transaction_types' =>  $transaction_types,
        'crate_sizes' =>  $crate_sizes,
        'branch' => $branch ,
        'departments' => $departments ,
        'themify_icons' => $themify_icons->themifyIcons() ,
        'members' => $members,
        'rooms' => $rooms,
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
