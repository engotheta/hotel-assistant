<?php

namespace App\Http\Controllers;

use App\RoomType;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
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
    public function create( Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,  Branch $branch = null, Department $department = null)
    {
        //
        $result = RoomType::where([['name', $request->name]])->first();
        if($result) return back()->with('success',$request->name.'  Room Type already exists');

        $room_type = new RoomType;
        $room_type->name = $request->name;
        $room_type->details = filled($request->details) ?  $request->details : null ;

        try{
            $room_type->save();
        }

        catch(\Illuminate\Database\QueryException $e){
            back()->with('success','System Error new room type could not be saved');
        }

        return back()->with('success',$room_type->name.' Room Type has been successfully added');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function show(RoomType $roomType, Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function edit(RoomType $roomType,  Branch $branch = null, Department $department = null)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RoomType $roomType, Branch $branch = null, Department $department = null)
    {
      //

    }

    public function updateMany(Request $request,  Branch $branch = null, Department $department = null)
    {

        $ids = count($request->id) ;
        $names = count($request->name) ;
        $details = count($request->details);
        $n = 0;

        if(!($ids == $names && $names == $details)) return back()->with('success','changes could not be saved');

        foreach ($request->id as $id) {
          $room_type = RoomType::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'id'=>$request->id[$n],
              'details'=>$request->details[$n]
            ];

          $this->quickUpdate($req,$room_type);
          $n++;
        }

        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, RoomType $room_type, Branch $branch = null, Department $department = null)
    {
      //

        try{
          $room_type->name = $request->name;
          $room_type->details = filled($request->details) ?  $request->details : null ;
          $room_type->save();
        }

        catch(\Illuminate\Database\QueryException $e){

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomType  $roomType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RoomType $room_type, Branch $branch = null, Department $department = null)
    {
        //

        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        try{
          $room_type->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success',$room_type->name. ' Room type could not be deleted, some room might be referencing it');
        }

        return back()->with('success',$room_type->name. ' Room type was deleted successfully');
    }

}
