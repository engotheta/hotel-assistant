<?php

namespace App\Http\Controllers;

use App\CrateSize;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class CrateSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(  Branch $branch = null, Department $department = null)
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
        $result = CrateSize::where([['size', $request->size]])->first();
        if($result) return back()->with('success',$request->size.'  Crate size already exists');

        $crate_size= new CrateSize;
        $crate_size->size = $request->size;
        $crate_size->details = filled($request->details) ?  $request->details : null ;

        try{
            $crate_size->save();
        }

        catch(\Illuminate\Database\QueryException $e){
            back()->with('success','System Error new crate size could not be saved');
        }

        return back()->with('success',$crate_size->size.' Crate size has been successfully added');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\CrateSize  $crateSize
     * @return \Illuminate\Http\Response
     */
    public function show(CrateSize $crateSize, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CrateSize  $crateSize
     * @return \Illuminate\Http\Response
     */
    public function edit(CrateSize $crateSize, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CrateSize  $crateSize
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CrateSize $crateSize, Branch $branch = null, Department $department = null)
    {
        //
    }

    public function updateMany(Request $request,  Branch $branch = null, Department $department = null)
    {

          $ids = count($request->id) ;
          $names = count($request->name) ;
          $details = count($request->details);
          $n = 0;

          if(!($ids == $names && $names == $details))  return back()->with('success','changes could not be saved');

          foreach ($request->id as $id) {
            $crate_size = CrateSize::where('id', $id)->first();
            $req = (object)[
                'size'=>$request->size[$n],
                'id'=>$request->id[$n],
                'details'=>$request->details[$n]
              ];

            $this->quickUpdate($req,$crate_size);
            $n++;
          }

          return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, CrateSize $crateSize, Branch $branch = null, Department $department = null)
    {
      //
        $crate_size = $crateSize;
        $crate_size->size = $request->size;
        $crate_size->details = filled($request->details) ?  $request->details : null ;

        try{
          $crate_size->save();
        }

        catch(\Illuminate\Database\QueryException $e){

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CrateSize  $crateSize
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrateSize $crate_size, Branch $branch = null, Department $department = null)
    {
          //
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');

          try{
            $crate_size->delete();
          }

          catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',$crate_size->size. ' Crate size could not be deleted, some drinks might be referencing it');
          }

          return back()->with('success',$crate_size->size. ' crate size was deleted successfully');

    }




}
