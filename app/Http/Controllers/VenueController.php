<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Branch  $branch = null, Department $department = null)
    {
        //getting all the venues to index
        $venues = ($branch)? $branch->venues : Drink::all();

        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.index.index_venues',$functions->getParameters($branch,$department,$venues,'venues'));
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
         return view('pages.add.add_venue',$functions->getParameters($branch,$department));
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
        $functions = new FunctionController;
        $result = Venue::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return back()->with('success',$request->name.' venue already exists in this branch');

        $venue = new Venue;
        $venue->name = $request->name;
        $venue->ac = $request->ac ;
        $venue->fan = $request->fan ;
        $venue->weekend_price = filled($request->weekend_price) ?  $request->weekend_price : null ;
        $venue->weekday_price = filled($request->weekday_price) ?  $request->weekday_price : null ;
        $venue->floor = filled($request->floor) ?  $request->floor : null ;
        $venue->capacity = filled($request->capacity) ?  $request->capacity : null ;
        $venue->details = filled($request->details) ?  $request->details : null ;
        $venue->branch_id = $request->branch_id;
        $venue->slug = str_replace(" ","-",trim($venue->name));

        try{
          $venue->save();
          $pic = new PictureController;
          $pic->storeAndAttach($request,$venue,'A picture for '.$venue->name.' activity');
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',$venue->name.' Venue could not be added due to a system Error');
        }

        return redirect($functions->getReturnLink($branch,$department))->with('success',$venue->name.' has been successfully added as a venue');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $venue = $functions->matchToBranch($branch, $venue,'venues','venue');
        //filter some contents for branch or department depending on the url
        return view('pages.view.view_venue',$functions->getParameters($branch,$department,$venue,'venue'));

    }

    public function showToDelete(Venue $venue, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $venue = $functions->matchToBranch($branch, $venue,'venues','venue');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_venue',$functions->getParameters($branch,$department,$venue,'venue'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $venue = $functions->matchToBranch($branch, $venue,'venues','venue');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.edit_venue',$functions->getParameters($branch,$department,$venue,'venue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        $result = Venue::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        $name = $venue->name;

        if(!$result)  $venue->name = $request->name;

        $venue->ac = $request->ac ;
        $venue->fan = $request->fan ;
        $venue->weekend_price = filled($request->weekend_price) ?  $request->weekend_price : null ;
        $venue->weekday_price = filled($request->weekday_price) ?  $request->weekday_price : null ;
        $venue->floor = filled($request->floor) ?  $request->floor : null ;
        $venue->capacity = filled($request->capacity) ?  $request->capacity : null ;
        $venue->details = filled($request->details) ?  $request->details : null ;
        $venue->slug = str_replace(" ","-",trim($venue->name));

        try{
          $venue->save();
          $pic = new PictureController;
          $pic->storeAndAttach($request,$venue,'A picture for '.$venue->name.' activity');
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success',' System Error while saving the changes');
        }

        if($name != $venue->name){
            return redirect($functions->getReturnLink($branch,$department))->with('success',$venue->name.' changes have been successfully saved');
        }

        return back()->with('success',$venue->name.' changes have been successfully saved');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $venue = $functions->matchToBranch($branch, $venue,'venues','venue');
        $name = $venue->name;

        try{
          $venue->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return redirect(($functions->getReturnLink($branch,$department)))->with('success','the venue: '.$name. ', cannot be deleted, since it is in use');
        }

        return redirect(($functions->getReturnLink($branch,$department)))->with('success','the venue: '.$name. ', has been deleted successfully');
    }
}
