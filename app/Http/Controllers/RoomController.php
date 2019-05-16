<?php

namespace App\Http\Controllers;

use App\Room;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch  $branch = null, Department $department = null)
    {
        //
        $rooms = ($branch)? $branch->rooms->sortBy('floor')->sortBy('branch_id') : Room::all()->sortBy('floor')->sortBy('branch_id');

        $functions = new FunctionController;
        //set the right department if there are doubles
        if($branch) $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url

        return view('pages.index.index_rooms',$functions->getParameters($branch,$department,$rooms,'rooms'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create(Branch $branch = null, Department $department = null)
     {
         //
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.add_room',$functions->getParameters($branch,$department));
     }

     public function createMany(Branch $branch = null, Department $department = null )
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.many.add_many_rooms',$functions->getParameters($branch,$department));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch = null, Department $department = null)
    {
        //return if room exists
        $functions = new FunctionController;
        $result = Room::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return back()->with('success','Room '.$request->name.'  already exists in this branch');

        // create a new room
        $room = new Room;
        $room->name = $request->name;
        $room->branch_id = $request->branch_id;
        $room->room_type_id = $request->room_type_id ;
        $room->ac = $request->ac ;
        $room->fan = $request->fan ;
        $room->price = filled($request->price) ?  $request->price : null ;
        $room->holiday_price = filled($request->holiday_price) ?  $request->holiday_price : $request->price ;
        $room->floor = filled($request->floor) ?  $request->floor : null ;
        $room->details = filled($request->details) ?  $request->details : null ;
        $room->slug = str_replace(" ","-",trim($room->name));

        // save and attach pictures to room
        try{
            $room->save();
            $pic = new PictureController;
            $pic->storeAndAttach($request,$room,'A picture for room '.$room->name);
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',$room->name.' Room could not be added due to a system Error');
        }

        return redirect($functions->getReturnLink($branch,$department))->with('success','Room '.$room->name.' has been successfully added to the branch');
    }

    public function storeMany(Request $request, Branch $branch, Department $department = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');

          $names = count($request->name) ;
          $prices = count($request->price);
          $room_type_ids = count($request->room_type_id);
          $n = 0;
          $msg = null;

          if(!($names == $prices && $prices == $room_type_ids)) return back()->with('success','System missmatch room could not be added');

          foreach ($request->name as $name) {
            $req = (object)[
                'branch_id'=>$branch->id,
                'name'=>$request->name[$n],
                'price'=>$request->price[$n],
                'stock'=>$request->stock[$n],
                'holiday_price'=>$request->holiday_price[$n],
                'room_type_id'=>$request->room_type_id[$n],
                'ac'=>$request->ac[$n],
                'fan'=>$request->fan[$n],
                'floor'=>$request->floor[$n],
                'details'=>$request->details[$n],
              ];

            $msg.=$this->quickStore($req);
            $n++;
          }

          if($msg) return redirect($functions->getReturnLink($branch,$department))->with('success',$msg);
          return redirect($functions->getReturnLink($branch,$department))->with('success','new Rooms were added successfully');
    }

    public function quickStore($request)
    {
        //
        $result = Room::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return $request->name.' skipped because already exists in this branch as a room, ';

        $room = new Room;
        $room->name = $request->name;
        $room->branch_id = $request->branch_id;
        $room->room_type_id = $request->room_type_id ;
        $room->ac = $request->ac ;
        $room->fan = $request->fan ;
        $room->price = filled($request->price) ?  $request->price : null ;
        $room->holiday_price = filled($request->holiday_price) ?  $request->holiday_price : $request->price ;
        $room->floor = filled($request->floor) ?  $request->floor : null ;
        $room->details = filled($request->details) ?  $request->details : null ;
        $room->slug = str_replace(" ","-",trim($room->name));

        try{
          $room->save();
        }

        catch(\Illuminate\Database\QueryException $e){
          return 'System Error '.$request->name.' could be added, ';
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        if($department) $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate room if there are doubles, due to presence in all the branches
        if($branch) $room = $functions->matchToBranch($branch, $room,'rooms','room');
        if(!$room) return back()->with('success','Room and branch do not match');
        //filter some contents for branch or department depending on the url
        return view('pages.view.view_room',$functions->getParameters($branch,$department,$room,'room'));

    }

    public function showToDelete(Room $room, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $room = $functions->matchToBranch($branch, $room,'rooms','room');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_room',$functions->getParameters($branch,$department,$room,'room'));

    }

    public function showRoomVariables(Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles in the whole hotel
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.rooms_variables',$functions->getParameters($branch,$department));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate room if there are doubles, due to presence in all the branches
        $room = $functions->matchToBranch($branch, $room,'rooms','room');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.edit_room',$functions->getParameters($branch,$department,$room,'room'));
    }

    public function editMany( Branch  $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.many.edit_many_rooms',$functions->getParameters($branch,$department));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room, Branch $branch=null, Department $department=null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        $result = Room::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        $name = $room->name;

        if(!$result) $room->name = $request->name;

        $room->room_type_id = $request->room_type_id ;
        $room->ac = $request->ac ;
        $room->fan = $request->fan ;
        $room->price = filled($request->price) ?  $request->price : null ;
        $room->holiday_price = filled($request->holiday_price) ?  $request->holiday_price : $request->price ;
        $room->floor = filled($request->floor) ?  $request->floor : null ;
        $room->details = filled($request->details) ?  $request->details : null ;
        $room->slug = str_replace(" ","-",trim($room->name));

        try{
            $room->save();
            $pic = new PictureController;
            $pic->storeAndAttach($request,$room,'A picture for room '.$room->name);
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',' System Error while saving the changes');
        }

        if($name != $room->name){
            return redirect($functions->getReturnLink($branch,$department))->with('success','Room '.$room->name.' changes have been successfully saved');
        }

        return back()->with('success','Room '.$room->name.' changes have been successfully saved');
    }

    public function updateMany(Request $request, Branch $branch, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        $ids = count($request->id) ;
        $names = count($request->name) ;
        $prices = count($request->price);
        $room_type_ids = count($request->room_type_id);
        $n = 0;
        $msg = '';

        if(!($ids == $names && $names == $prices && $prices == $room_type_ids)) return back()->with('success','changes could not be saved');

        foreach ($request->id as $id) {
          $room = Room::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'id'=>$request->id[$n],
              'stock'=>$request->stock[$n],
              'price'=>$request->price[$n],
              'holiday_price'=>$request->holiday_price[$n],
              'room_type_id'=>$request->room_type_id[$n],
              'ac'=>$request->ac[$n],
              'fan'=>$request->fan[$n],
              'floor'=>$request->floor[$n],
              'details'=>$request->details[$n],
            ];

          $msg.=$this->quickUpdate($req,$room,$branch,$department);
          $n++;
        }

        if($msg)  return back()->with('success', $msg);
        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, Room $room, Branch $branch, Department $department = null)
    {
    //
        $functions = new FunctionController;
        $result = Room::where([['name', $request->name],['branch_id', $branch->id]])->first();
        $name = $room->name;

        if(!$result) $room->name = $request->name;

        $room->room_type_id = $request->room_type_id ;
        $room->ac = $request->ac ;
        $room->fan = $request->fan ;
        $room->price = filled($request->price) ?  $request->price : null ;
        $room->holiday_price = filled($request->holiday_price) ?  $request->holiday_price : $request->price ;
        $room->floor = filled($request->floor) ?  $request->floor : null ;
        $room->details = filled($request->details) ?  $request->details : null ;
        $room->slug = str_replace(" ","-",trim($room->name));

        try{
          $room->save();
        }
        catch(\Illuminate\Database\QueryException $e){
            return $room->name."System Error changes could not be saved, ";
        }

        if($result AND $name != $request->name){
          return ' '.$name.' was not changed to '.$request->name.'  to avoid duplicates, ';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room, Branch $branch, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate room if there are doubles, due to presence in all the branches
        $room = $functions->matchToBranch($branch, $room,'rooms','room');
        $name = $room->name;

        try{
          $room->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return redirect(($functions->getReturnLink($branch,$department)))->with('success','the room: '.$name. ', cannot be deleted, since it is in use');
        }

        return redirect(($functions->getReturnLink($branch,$department)))->with('success','the room: '.$name. ', has been deleted successfully');
    }
}
