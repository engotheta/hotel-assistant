<?php

namespace App\Http\Controllers;

use App\Title;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class TitleController extends Controller
{
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
        $result = Title::where([['name', $request->name]])->first();
        if($result) return back()->with('success',$request->name.'  Title already exists');

        $title = new Title;
        $title->name = $request->name;
        $title->details = filled($request->details) ?  $request->details : null ;

        try{
          $title->save();
        }

        catch(\Illuminate\Database\QueryException $e){
          back()->with('success','System Error the new title could not be saved');
        }

        return back()->with('success',$title->name.' Title has been successfully added');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function show(Title $title, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function edit(Title $title, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Title $title, Branch $branch = null, Department $department = null)
    {
        //
    }

    public function updateMany(Request $request, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        $ids = count($request->id) ;
        $names = count($request->name) ;
        $details = count($request->details);
        $n = 0;

        if(!($ids == $names && $names == $details))  return back()->with('success','changes could not be saved');

        foreach ($request->id as $id) {
          $title = Title::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'id'=>$request->id[$n],
              'details'=>$request->details[$n]
            ];

          $this->quickUpdate($req,$title);
          $n++;
        }

        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, Title $title, Branch $branch = null, Department $department = null)
    {
      //
        try{
          $title->name = $request->name;
          $title->details = filled($request->details) ?  $request->details : null ;
          $title->save();
        }

        catch(\Illuminate\Database\QueryException $e){

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Title  $title
     * @return \Illuminate\Http\Response
     */
    public function destroy(Title $title, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        $name = $title->name;

        try{
          $title->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success',$title->name. ' Title could not be deleted, some room might be referencing it');
        }

        return back()->with('success',$title->name. ' Title was deleted successfully');
    }
}
