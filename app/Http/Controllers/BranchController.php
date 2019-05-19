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

    public function branchParameters(Branch $branch)
    {
        $themify_icons = new FontIcon;
        return [
          'hotel' => DB::table('settings')->where('name', 'hotel_name')->first(),
          'functions'=> new FunctionController,
          'roles' => Role::all(),
          'titles' => Title::all(),
          'services' => Service::all(),
          'room_types' => RoomType::all(),
          'drink_types' =>  DrinkType::all(),
          'transaction_types' => TransactionType::all(),
          'crate_sizes' => CrateSize::all(),
          'admin_items' => $this->getAdminItems($branch),
          'view_items' => $this->getViewItems($branch),
          'themify_icons' => $themify_icons->themifyIcons() ,
          'branch' => $branch ,
          'departments' => $branch->departments ,
          'members' => $branch->members,
          'rooms' => $branch->rooms,
          'drinks' => $branch->drinks,
          'foods' => $branch->foods,
          'venues' => $branch->venues,
          'activities' => $branch->activities,

        ];
    }

    public function getAdminItems(Branch $branch)
    {
        //
          $admin_items =  [
                  [
                    'name' => 'departments',
                    'actions' => [['name'=>'add','link'=>'/departments/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
                    'target'=>'departmentsModal' ],
                  [
                    'name' => 'members',
                    'actions' => [['name'=>'add','link'=>'/users/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'titles','link'=>'/titles/'.$branch->slug]] ,
                    'target'=>'membersModal' ],
                  [
                    'name' => 'activities',
                    'actions' => [['name'=>'add','link'=>'/activities/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
                    'target'=>'activitiesModal' ],
                  [
                    'name' => 'venues',
                    'actions' => [['name'=>'add','link'=>'/venues/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
                    'target'=>'venuesModal' ],
                  [
                    'name' => 'rooms',
                    'actions' => [['name'=>'add','link'=>'/rooms/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'variables','link'=>'/rooms-variables/'.$branch->slug]] ,
                    'target'=>'roomsModal' ],
                  [
                    'name' => 'drinks',
                    'actions' => [['name'=>'add','link'=>'/drinks/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'variables','link'=>'/drinks-variables/'.$branch->slug]] ,
                    'target'=>'drinksModal' ],
                  [
                    'name' => 'foods',
                    'actions' => [['name'=>'add','link'=>'/foods/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
                    'target'=>'foodsModal' ],
          ];

          return $admin_items;

    }

    public function getViewItems(Branch $branch)
    {
        $view_items = [
              [
                'name' => 'business days',
                'link' => '/businessdays/'.$branch->slug,
                'instance' => $branch->recentBusinessdays(), ],
              [
                'name' => 'unpaid loans',
                'link' => '/unpaid-loans/.$branch->slug',
                'instance' => $branch->unpaidLoans(), ],
              [
                'name' => 'venue bookings',
                'link' => '/venue-bookings/'.$branch->slug,
                'instance' => $branch->venueBookings(), ],
              [
                'name' => 'members',
                'link' => '/members/'.$branch->slug,
                'instance' => $branch->members, ],
              [
                'name' => 'rooms',
                'link' => '/rooms/'.$branch->slug,
                'instance' => $branch->rooms, ],
              [
                'name' => 'drinks',
                'link' => '/drinks/'.$branch->slug,
                'instance' => $branch->drinks, ],
              [
                'name' => 'foods',
                'link' => '/foods/'.$branch->slug,
                'instance' => $branch->foods, ],
              [
                'name' => 'venues',
                'link' => '/venues/'.$branch->slug,
                'instance' => $branch->venues, ],
              [
                'name' => 'activities',
                'link' => '/activities/'.$branch->slug,
                'instance' => $branch->activities, ],
        ];

        return $view_items;
    }


}
