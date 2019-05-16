<?php

namespace App\Http\Controllers;

use App\Businessday;
use Illuminate\Http\Request;
use App\Branch;
use App\Department;
use App\Activity;

class BusinessdayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
     public function __construct()
     {
         $this->middleware('auth');
     }

     public function index( Branch  $branch = null, $department = null )
     {
         $businessdays = ($branch)? $branch->businessdays->sortByDesc('name')->sortBy('branch_id') : Businessday::all()->sortByDesc('name')->sortBy('branch_id');

         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);

         //set the right department/activity if there are doubles
         if($functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'departments','department');
         if(!$functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'activities','activity');
         //filter some contents for branch or department depending on the url
         return view('pages.index.index_businessdays',$functions->getParameters($branch,$department,$businessdays,'businessdays'));

     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Branch  $branch = null, $department = null)
     {
         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);

         //set the right department/activity if there are doubles
         if($functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'departments','department');
         if(!$functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'activities','activity');
         //filter some contents for branch or department depending on the url
         return view('pages.add.add_businessday',$functions->getParameters($branch,$department));
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request, Branch $branch = null, $department = null)
     {
         //
         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);

         if(isset($request->department_id)) $result = Businessday::where([['name', $request->name],['branch_id', $request->branch_id],['department_id', $request->department_id]])->first();
         if(isset($request->activity_id)) $result = Businessday::where([['name', $request->name],['branch_id', $request->branch_id],['activity_id', $request->department_id]])->first();
         if($result) return back()->with('success',$request->name.' this day has already started in this department');

         $businessday= new Businessday;
         $businessday->name = $request->name;
         $businessday->branch_id = $request->branch_id;
         $businessday->user_id = $request->user_id;
         $businessday->department_id = isset($request->department_id)? $request->department_id : null;
         $businessday->activity_id = isset($request->activity_id)?   $request->activity_id : null;
         $businessday->sales = filled($request->sales) ?  $request->sales : 0 ;
         $businessday->paid_loans = filled($request->paid_loans) ?  $request->paid_loans : 0 ;
         $businessday->bookings = filled($request->bookings) ?  $request->bookings : 0 ;
         $businessday->petty_cash = filled($request->petty_cash) ?  $request->petty_cash : 0 ;
         $businessday->purchases = filled($request->purchases) ?  $request->purchases : 0 ;
         $businessday->expenditures = filled($request->expenditures) ?  $request->expenditures : 0 ;
         $businessday->loans = filled($request->loans) ?  $request->loans : 0 ;
         $businessday->loss = filled($request->loss) ?  $request->loss : 0 ;
         $businessday->details = filled($request->details) ?  $request->details : null ;
         $businessday->slug = str_replace(" ","-",trim($businessday->name));

         if(isset($request->complete)) $businessday->complete = true ;

         try{
           $businessday->save();
           $pic = new PictureController;
           $pic->storeAndAttach($request,$businessday,'A picture for a for the businessday '.$businessday->name);
         }

         catch(\Illuminate\Database\QueryException $e){
             return back()->with('success',$businessday->name.' Businessday could not be added');
         }

         $functions = new FunctionController;
         return redirect($functions->getLink('businessdays',$businessday,$branch,$department))->with('success',$businessday->name.' has been successfully created');

     }


    /**
     * Display the specified resource.
     *
     * @param  \App\Businessday  $businessday
     * @return \Illuminate\Http\Response
     */
     public function show(Businessday $businessday, Branch $branch = null, $department = null)
     {
         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);

         //set the right department/activity if there are doubles
         if($functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'departments','department');
         if(!$functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'activities','activity');
         //filter some contents for branch or department depending on the url
         $businessday = $functions->matchToBranch($branch, $businessday,'businessdays','businessday');
         return view('pages.view.view_businessday',$functions->getParameters($branch,$department,$businessday,'businessday'));

     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Businessday  $businessday
     * @return \Illuminate\Http\Response
     */
    public function edit(Businessday $businessday, Branch  $branch = null, $department = null)
    {
        $functions = new FunctionController;
        $department = $functions->getIFDepartment($branch,$department);
        //set the right department if there are doubles
        if($functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'departments','department');
        if(!$functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'activities','activity');
        // set appropriate businessday if there are doubles, due to presence in all the branches
        $businessday = $functions->matchToBranch($branch, $businessday,'businessdays','businessday');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.edit_businessday',$functions->getParameters($branch,$department,$businessday,'businessday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Businessday  $businessday
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request, Businessday $businessday, Branch $branch = null, $department = null)
     {
         //
         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);

         if(isset($request->department_id)) $result = Businessday::where([['name', $request->name],['branch_id', $request->branch_id],['department_id', $request->department_id]])->first();
         if(isset($request->activity_id)) $result = Businessday::where([['name', $request->name],['branch_id', $request->branch_id],['activity_id', $request->department_id]])->first();
         if(!$result) $businessday->name = $request->name;

         $businessday->sales = filled($request->sales) ?  $request->sales : 0 ;
         $businessday->paid_loans = filled($request->paid_loans) ?  $request->paid_loans : 0 ;
         $businessday->bookings = filled($request->bookings) ?  $request->bookings : 0 ;
         $businessday->petty_cash = filled($request->petty_cash) ?  $request->petty_cash : 0 ;
         $businessday->purchases = filled($request->purchases) ?  $request->purchases : 0 ;
         $businessday->expenditures = filled($request->expenditures) ?  $request->expenditures : 0 ;
         $businessday->loans = filled($request->loans) ?  $request->loans : 0 ;
         $businessday->loss = filled($request->loss) ?  $request->loss : 0 ;
         $businessday->details = filled($request->details) ?  $request->details : null ;
         $businessday->slug = str_replace(" ","-",trim($businessday->name));

         if(isset($request->complete)) $businessday->complete = true ;

         try{
           $businessday->save();
           $pic = new PictureController;
           $pic->storeAndAttach($request,$businessday,'A picture for the businessday '.$businessday->name);
         }

         catch(\Illuminate\Database\QueryException $e){
             return redirect($functions->getLink('businessdays',$businessday,$branch,$department))->with('success', 'System Error while saving the changes');
         }

        return redirect($functions->getLink('businessdays',$businessday,$branch,$department))->with('success',$businessday->name.' changes been successfully saved');
     }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Businessday  $businessday
     * @return \Illuminate\Http\Response
     */

     public function destroy(Businessday $businessday, Branch $branch = null, $department = null)
     {
         $functions = new FunctionController;
         $department = $functions->getIFDepartment($branch,$department);
         //set the right department if there are doubles
         if($functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'departments','department');
         if(!$functions->isDepartment($department)) $department = $functions->matchToBranch($branch, $department,'activities','activity');
         // set appropriate businessday if there are doubles, due to presence in all the branches
         $businessday = $functions->matchToBranch($branch, $businessday,'businessdays','businessday');
         $name = $businessday->name;

         try{
           $businessday->delete();
         }

         catch(\Illuminate\Database\QueryException $e){
           return redirect(($functions->getReturnLink($branch,$department)))->with('success','the businessday: '.$name. ', cannot be deleted, since it is in use');
         }

         return redirect(($functions->getReturnLink($branch,$department)))->with('success','the businessday: '.$name. ', has been deleted successfully');
     }
}
