<?php

namespace App\Http\Controllers;

use App\DrinkType;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class DrinkTypeController extends Controller
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
    public function create(Branch $branch = null, Department $department = null)
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
        $result = DrinkType::where([['name', $request->name]])->first();
        if($result) return back()->with('success',$request->name.'  Drink Type already exists');

        $drink_type = new DrinkType;
        $drink_type->name = $request->name;
        $drink_type->details = filled($request->details) ?  $request->details : null ;

        try{
          $drink_type->save();
        }

        catch(\Illuminate\Database\QueryException $e){
            back()->with('success','System Error new drink type could not be saved');
        }

        return back()->with('success',$drink_type->name.' Drink Type has been successfully added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DrinkType  $drinkType
     * @return \Illuminate\Http\Response
     */
    public function show(DrinkType $drinkType, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DrinkType  $drinkType
     * @return \Illuminate\Http\Response
     */
    public function edit(DrinkType $drinkType, Branch $branch = null, Department $department = null)
    {
        //
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DrinkType  $drinkType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrinkType $drinkType, Branch $branch = null, Department $department = null)
    {
        //
    }

    public function updateMany(Request $request, Branch $branch = null, Department $department = null)
    {
          $ids = count($request->id) ;
          $names = count($request->name) ;
          $details = count($request->details);
          $n = 0;

          if(!($ids == $names && $names == $details))  return back()->with('success','changes could not be saved');

          foreach ($request->id as $id) {
            $drink_type = DrinkType::where('id', $id)->first();
            $req = (object)[
                'name'=>$request->name[$n],
                'id'=>$request->id[$n],
                'details'=>$request->details[$n]
              ];

            $this->quickUpdate($req,$drink_type);
            $n++;
          }

          return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, DrinkType $drinkType, Branch $branch = null, Department $department = null)
    {
      //
        $drink_type = $drinkType;
        $drink_type->name = $request->name;
        $drink_type->details = filled($request->details) ?  $request->details : null ;

        try{
          $drink_type->save();
        }

        catch(\Illuminate\Database\QueryException $e){

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DrinkType  $drinkType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrinkType $drink_type, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        try{
          $drink_type->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success',$drink_type->name. ' Drink type could not be deleted, some drinks might be referencing it');
        }

        return back()->with('success',$drink_type->name. ' Drink type was deleted successfully');
    }


}
