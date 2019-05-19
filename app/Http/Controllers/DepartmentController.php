<?php

namespace App\Http\Controllers;

use App\Department;
use App\Branch;
use App\Businessday;
use App\Role;
use App\Title;
use App\Service;
use App\Loan;
use App\Booking;
use App\FontIcon;
use App\TransactionType;
use App\DrinkType;
use App\RoomType;
use App\CrateSize;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
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
    public function index( Branch  $branch = null, Department $department = null)
    {
        //
        $departments = ($branch)? $branch->departments : Department::all();

        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view(' ',$functions->getParameters($branch,$department,$departments,'departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Branch  $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.add.add_department',$functions->getParameters($branch,$department));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch = null, Department $department = null)
    {
          //
          $result = Department::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
          if($result) return back()->with('success', 'the '.$request->name.' department already exists');

          $department = new Department;
          $department->name = $request->name;
          $department->slug = str_replace(" ","-",trim($request->name));
          $department->details = filled($request->details) ?  $request->details : null ;
          $department->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;
          $department->branch_id = $request->branch_id;

          try{
              $department->save();

              //attach services
              $services = Service::all();
              foreach($services as $service){
                if(isset($request['service_'.$service->id])){
                  $department->services()->attach($service);
                }
              }

              $pic = new PictureController;
              $pic->storeAndAttach($request,$department,'A picture for '.$department->name.' department');
          }

          catch(\Illuminate\Database\QueryException $e){
              return back()->with('success','System Error while saving the new department');
          }

          $functions = new FunctionController;
          return redirect($functions->getReturnLink($branch,null))->with('success', 'the '.$department->name.' department has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department, Branch $branch = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');
          return view('department',$functions->getParameters($branch,$department));
    }

    public function showToDelete(Department $department, Branch $branch = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');
          // set appropriate drink if there are doubles, due to presence in all the branches
          return view('pages.delete.delete_department',$functions->getParameters($branch,null,$department,'department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department, Branch $branch=null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        return view('pages.edit.edit_department',$functions->getParameters($branch,null,$department,'department'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department , Branch $branch = null)
    {
        //
        $functions = new FunctionController;

        $name = $department->name;
        if(!$branch->departments->where('name',$request->name)->first()){
          $department->name = $request->name;
        }

        $department->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;
        $department->details = filled($request->details) ?  $request->details : $department->details ;
        $department->slug = str_replace(" ","-",trim($department->name));

        try{
            $department->save();
            //attach selected / detach services to the department
            $services = Service::all();
            foreach($services as $service){
              if($department->services->where('id',$service->id)->first()){
                if(!isset($request['service_'.$service->id])) {
                  $department->services()->detach($service);
                }
              }else{
                if(isset($request['service_'.$service->id])){
                  $department->services()->attach($service);
                }
              }
            }

            $pic = new PictureController;
            $pic->storeAndAttach($request,$department,'A picture for '.$department->name.' department');
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success', 'System Error while saving the changes');
        }

        if($name != $request->name) {
          return redirect($functions->getReturnLink($branch,null))->with('success', 'the '.$department->name.' department changes have been saved successfully ');
        }

        return back()->with('success', 'the '.$department->name.' department changes have been saved successfully ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, Branch $branch=null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        $name = $department->name;

        try{
          $department->delete();
        }
        catch(\Illuminate\Database\QueryException $e){
            return redirect(($functions->getReturnLink($branch,null)))->with('success',$name. ' department cannot be deleted, since it is in use');
        }

        return redirect(($functions->getReturnLink($branch,null)))->with('success',$name. ' department has been deleted successfully');
    }

    public function departmentParameters(Department $department){
      $parameters = array();
      $services = $department->services->sortBy('name');
      $themify_icons = new FontIcon;
      $functions = new FunctionController;

      $parameters =  [
        'hotel' => DB::table('settings')->where('name', 'hotel_name')->first(),
        'roles' => Role::all(),
        'titles' => Title::all(),
        'admin_items' => $this->getAdminItems($department),
        'view_items' => $this->getViewItems($department),
        'themify_icons' => $themify_icons->themifyIcons(),
        'members' => $department->branch->users,
        'branch' => $department->branch,
        'department' => $department,
        'services' =>  $services,
        'functions' => $functions,
      ];

      foreach ($services as $service) {
        $parameters[$service->name] = $functions->getServiceAssets($service,$department->branch);

        if($service->name == 'drinks') {
          $parameters['drink_types'] = DrinkType::all();
          $parameters['crate_sizes'] = CrateSize::all();
        }

        if($service->name == 'rooms'){
          $parameters['room_types'] = RoomType::all();
        }
      }

      return $parameters;
    }

    public function getAdminItems(Department $department)
    {
        //
          $admin_items = array();

          $rooms =  [
                'name' => 'rooms',
                'target'=>'roomsModal',
                'actions' => [
                        ['name'=>'add','link'=>'/rooms/'.$department->branch->slug.'/'.$department->slug.'/add'],
                        ['name'=>'edit'],
                        ['name'=>'delete'],
                        ['name'=>'variables', 'link'=>'/rooms-variables/'.$department->branch->id]
           ],];

          $venues = [
                'name' => 'venues',
                'target'=>'venuesModal',
                'actions' => [
                        ['name'=>'add', 'link'=>'/venues/'.$department->branch->slug.'/'.$department->slug.'/add'],
                        ['name'=>'edit'],
                        ['name'=>'delete']
          ],];

          $drinks = [
              'name' => 'drinks',
              'target'=>'drinksModal',
              'actions' => [
                        ['name'=>'add','link'=>'/drinks/'.$department->branch->slug.'/'.$department->slug.'/add'],
                        ['name'=>'edit'],
                        ['name'=>'delete'],
                        ['name'=>'variables','link'=>'/drinks-variables/'.$department->branch->slug.'/'.$department->slug]
            ]];

          $foods = [
                'name' => 'foods',
                'target'=>'foodsModal',
                'actions' => [
                        ['name'=>'add','link'=>'/foods/'.$department->branch->slug.'/'.$department->slug.'/add'],
                        ['name'=>'edit'],
                        ['name'=>'delete']
          ],];

          foreach($department->services as $service ){
              switch($service->name){
                case 'rooms' :  $admin_items[] = $rooms ; break;
                case 'drinks':  $admin_items[] = $drinks; break;
                case 'venues':  $admin_items[] = $venues; break;
                case 'foods' :  $admin_items[] = $foods; break;
              }
          }

          return $admin_items;
    }

    public function getViewItems(Department $department)
    {
        $view_items = array();

        $drinkz = $department->branch->drinks;
        $roomz = $department->branch->rooms;
        $foodz = $department->branch->foods;
        $venuez = $department->branch->venues;

        $back_track_days = DB::table('settings')->where('name', 'back_track_days')->first();
        $businessdays = Businessday::where('department_id','=',$department->id)->orderBy('id','desc')->take((int)$back_track_days->value)->get();
        $unpaid_loans = Loan::where([['complete',false],['department_id',$department->id]])->get();
        $venue_bookings = Booking::where([
                ['bookable_type','App/Venue'],
                ['due_date','>=',Carbon::now()->toDateTimeString()],
                ['branch_id',$department->branch->id]])->get();

        $view_items[] = [
          'name' => 'business days',
          'link' => 'businessdays',
          'instance' => $businessdays, ];

        $view_items[] = [
          'name' => 'unpaid loans',
          'link' => '/unpaid-loans/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $unpaid_loans, ];

        $venues_booking =  [
          'name' => 'venue bookings',
          'link' => '/venue-bookings/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $venue_bookings, ];

        $venues = [
          'name' => 'venues',
          'link' => '/venues/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $venuez,];

        $rooms = [
          'name' => 'rooms',
          'link' => '/rooms/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $roomz, ];

        $drinks = [
          'name' => 'drinks',
          'link' => '/drinks/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $drinkz, ];

        $foods = [
          'name' => 'foods',
          'link' => '/foods/'.$department->branch->slug.'/'.$department->slug,
          'instance' => $foodz, ];

        foreach($department->services as $service ){
            switch($service->name){
              case 'venues' : $view_items[] = $venues_booking;  $view_items[] = $venues; break;
              case 'rooms' : $view_items[] = $rooms; break;
              case 'foods' : $view_items[] = $foods; break;
              case 'drinks' : $view_items[] = $drinks; break;
            }
        }
        return $view_items;
    }

}
