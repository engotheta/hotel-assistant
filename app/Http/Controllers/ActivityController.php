<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Branch;
use App\FontIcon;
use App\Department;  //obsolete
use App\Businessday;
use App\Loan;
use App\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
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
    public function index(Branch $branch = null, Department $department = null)
    {
        //
        $activities = ($branch)? $branch->activities : Activity::all();
        $functions = new FunctionController;
        //filter some contents for branch or department depending on the url
        return view('pages.index.index_activities',$functions->getParameters($branch,$department,$activities,'activities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Branch  $branch = null, Department $department = null)
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.add_activity',$functions->getParameters($branch,$department));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Branch $branch = null, Department $department = null)
    {
        //
          $result = Activity::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
          if($result)  return back()->with('success',$request->name.' already exists in this branch');

          $activity = new Activity;
          $activity->name = $request->name;
          $activity->slug = str_replace(" ","-",trim($request->name));
          $activity->price = filled($request->price) ?  $request->price : null ;
          $activity->details = filled($request->details) ?  $request->details : null ;
          $activity->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;
          $activity->branch_id = $request->branch_id;

          try{
              $activity->save();
              $transaction_types = TransactionType::all();
              foreach($transaction_types as $transaction_type){
                if(isset($request['transaction_type_'.$transaction_type->id])){
                  $activity->transactionTypes()->attach($transaction_type);
                }
              }

              $pic = new PictureController;
              $pic->storeAndAttach($request,$activity,'A picture for '.$activity->name.' activity');
          }

          catch(\Illuminate\Database\QueryException $e){
              return back()->with('success', '  System Error while storing the new activity');
          }

          $functions = new FunctionController;
          return redirect($functions->getReturnLink($branch,$department))->with('success',$activity->name.' has been successfully added as an activity');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity, Branch $branch = null, $department = null)
    {
        //
        $functions = new FunctionController;
        // set appropriate drink if there are doubles, due to presence in all the branches
        $activity = $functions->matchToBranch($branch, $activity,'activities','activity');
        return view('pages.view.view_activity',$functions->getParameters($branch,$department,$activity,'activity'));
    }

    public function showActivity(Activity $activity, Branch $branch = null, $department = null)
    {
        //
        $functions = new FunctionController;
        // set appropriate drink if there are doubles, due to presence in all the branches
        $activity = $functions->matchToBranch($branch, $activity,'activities','activity');
        return view('activity',$functions->getParameters($branch,$activity));
    }

    public function showToDelete(Activity $activity, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $activity = $functions->matchToBranch($branch, $activity,'activities','activity');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_activity',$functions->getParameters($branch,$department,$activity,'activity'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity , Branch $branch = null, Department $department = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');
          // set appropriate drink if there are doubles, due to presence in all the branches
          $activity = $functions->matchToBranch($branch, $activity,'activities','activity');
          //filter some contents for branch or department depending on the url
          return view('pages.edit.edit_activity',$functions->getParameters($branch,$department,$activity,'activity'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity, Branch $branch=null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        // check if  the new name already exists in the system, use the old name if it does
        $result = Activity::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        $name = $activity->name;
        if(!$result) $activity->name = $request->name;

        $activity->price = filled($request->price) ?  $request->price : null ;
        $activity->details = filled($request->details) ?  $request->details : null ;
        $activity->contact_person_id = filled($request->contact_person_id) ?  $request->contact_person_id : null ;
        $activity->slug = str_replace(" ","-",trim($activity->name));

        try{
            $activity->save();
            $transaction_types = TransactionType::all();

            // attach the selected transaction types to the activity
            foreach($transaction_types as $transaction_type){
              if($activity->transactionTypes->where('id',$transaction_type->id)->first()){
                if(!isset($request['transaction_type_'.$transaction_type->id])) {
                  $activity->transactionTypes()->detach($transaction_type);
                }
              }else{
                if(isset($request['transaction_type_'.$transaction_type->id])){
                  $activity->transactionTypes()->attach($transaction_type);
                }
              }
            }

            $pic = new PictureController;
            $pic->storeAndAttach($request,$activity,'A picture for '.$activity->name.' activity');

        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success', '  System Error while saving the changes');
        }

        if($name!=$activity->name){
            return redirect($functions->getReturnLink($branch,$department))->with('success',$activity->name.' changes have been successfully changed');
        }

        return back()->with('success',$activity->name.' changes have been successfully changed');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $activity = $functions->matchToBranch($branch, $activity,'activities','activity');

        $name = $activity->name;

        try{
          $activity->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',$name. ' activity cannot be deleted, since it is in use');
        }

        return redirect($functions->getReturnLink($branch,$department))->with('success',$name. ' activity has been deleted successfully');
    }

    public function activityParameters(Activity $activity){
      $parameters = array();
      $themify_icons = new FontIcon;
      $functions = new FunctionController;

      $parameters =  [
        'hotel' => DB::table('settings')->where('name', 'hotel_name')->first(),
        'transaction_types' => TransactionType::where('for_activities',true)->get(),
        'admin_items' => $this->getAdminItems($activity),
        'view_items' => $this->getViewItems($activity),
        'themify_icons' => $themify_icons->themifyIcons(),
        'members' => $activity->branch->users,
        'branch' => $activity->branch,
        'activity' => $activity,
        'functions' => $functions,
      ];

      return $parameters;
    }

    public function getAdminItems(Activity $activity)
    {
        //
          $admin_items = array();

          return $admin_items;
    }

    public function getViewItems(Activity $activity)
    {
        $view_items = array();

        $back_track_days = DB::table('settings')->where('name', 'back_track_days')->first();
        $businessdays = Businessday::where('activity_id','=',$activity->id)->orderBy('id','desc')->take((int)$back_track_days->value)->get();
        $unpaid_loans = Loan::where([['complete',false],['activity_id',$activity->id]])->get();


        $view_items[] = [
          'name' => 'business days',
          'link' => 'businessdays',
          'instance' => $businessdays, ];

        $view_items[] = [
          'name' => 'unpaid loans',
          'link' => '/unpaid-loans/'.$activity->branch->slug.'/'.$activity->slug,
          'instance' => $unpaid_loans, ];


        return $view_items;
    }
}
