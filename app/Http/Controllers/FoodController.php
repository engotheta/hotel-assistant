<?php

namespace App\Http\Controllers;

use App\Food;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index( Branch  $branch = null, Department $department = null)
     {
         $foods = ($branch)? $branch->foods : Food::all();

         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.index.index_foods',$functions->getParameters($branch,$department,$foods,'foods'));

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
         return view('pages.add.add_food',$functions->getParameters($branch,$department));

     }

     public function createMany(Branch $branch = null, Department $department = null )
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.many.add_many_foods',$functions->getParameters($branch,$department));
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
        $functions = new FunctionController;
        $result = Food::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return back()->with('success',$request->name.'  already exists in this branch as food');

        $food = new Food;
        $food->name = $request->name;
        $food->branch_id = $request->branch_id;
        $food->price = $request->price ;
        $food->stock = filled($request->stock) ?  $request->stock : 0 ;
        $food->details = filled($request->details) ?  $request->details : null ;
        $food->slug = str_replace(" ","-",trim($food->name));

        try{
            $food->save();
            $pic = new PictureController;
            $pic->storeAndAttach($request,$food,'A picture for room '.$food->name);
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success','System error '.$food->name. ' could not be added');
        }

        return redirect($functions->getReturnLink($branch,$department))->with('success',$food->name.' has been successfully added food to the branch');
      }


        public function storeMany(Request $request, Branch $branch, Department $department = null)
        {
              $functions = new FunctionController;
              //set the right department if there are doubles
              $department = $functions->matchToBranch($branch, $department,'departments','department');

              $names = count($request->name) ;
              $prices = count($request->price) ;
              $msg = null;
              $n = 0;

              if(!($names == $prices))  return back()->with('success','System missmatch foods could not be added');

              foreach ($request->name as $name) {
                $req = (object)[
                    'name'=>$request->name[$n],
                    'branch_id'=>$branch->id,
                    'price'=>$request->price[$n],
                    'stock'=>$request->stock[$n],
                    'details'=>$request->details[$n]
                  ];

                $msg.=$this->quickStore($req);
                $n++;
              }

              if($msg) return redirect($functions->getReturnLink($branch,$department))->with('success',$msg);
              return redirect($functions->getReturnLink($branch,$department))->with('success','new foods were added successfully');
        }

        public function quickStore($request)
        {
            //
            $result = Food::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
            if($result) return $request->name.' skipped because already exists in this branch as food, ';

            $food = new Food;
            $food->name = $request->name;
            $food->branch_id = $request->branch_id;
            $food->price = $request->price ;
            $food->stock = filled($request->stock) ?  $request->stock : 0 ;
            $food->details = filled($request->details) ?  $request->details : null ;
            $food->slug = str_replace(" ","-",trim($food->name));

            try{
              $food->save();
            }

            catch(\Illuminate\Database\QueryException $e){
              return 'System Error '.$request->name.' could be added, ';
            }
        }


    /**
     * Display the specified resource.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
     public function show(Food $food, Branch $branch = null, Department $department = null)
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         // set appropriate food if there are doubles, due to presence in all the branches
         $food = $functions->matchToBranch($branch, $food,'foods','food');
         return view('pages.view.view_food ',$functions->getParameters($branch,$department,$food,'food'));

     }

    public function showToDelete(Food $food, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate food if there are doubles, due to presence in all the branches
        $food = $functions->matchToBranch($branch, $food,'foods','food');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_food',$functions->getParameters($branch,$department,$food,'food'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food, Branch  $branch = null, Department $department = null)
    {
      //
      $functions = new FunctionController;
      //set the right department if there are doubles
      $department = $functions->matchToBranch($branch, $department,'departments','department');
      // set appropriate food if there are doubles, due to presence in all the branches
      $food = $functions->matchToBranch($branch, $food,'foods','food');
      //filter some contents for branch or department depending on the url
      return view('pages.edit.edit_food',$functions->getParameters($branch,$department,$food,'food'));

    }

    public function editMany( Branch  $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.many.edit_many_foods',$functions->getParameters($branch,$department));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        $result = Food::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        $name = $food->name;
        if(!$result)  $food->name = $request->name;

        $food->price = $request->price ;
        $food->stock = filled($request->stock) ?  $request->stock : 0 ;
        $food->details = filled($request->details) ?  $request->details : null ;
        $food->slug = str_replace(" ","-",trim($food->name));

        try{
          $food->save();
          $pic = new PictureController;
          $pic->storeAndAttach($request,$food,'A picture for room '.$food->name);
        }

        catch(\Illuminate\Database\QueryException $e){
          return back()->with('success', '  System Error while saving the changes');
        }

        if($name!=$food->name){
            return redirect($functions->getReturnLink($branch,$department))->with('success',$food->name.' changes have been successfully saved');
        }

        return back()->with('success',$food->name.' changes have been successfully saved');
    }

    public function updateMany(Request $request, Branch $branch, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        $ids = count($request->id) ;
        $names = count($request->name) ;
        $prices = count($request->price);
        $stocks = count($request->stock);
        $n = 0;
        $msg = '';

        if(!($ids == $names && $names == $prices && $prices == $stocks)) return back()->with('success','changes could not be saved');

        foreach ($request->id as $id) {
          $food = Food::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'branch_id'=>$branch->id,
              'price'=>$request->price[$n],
              'stock'=>$request->stock[$n],
              'details'=>$request->details[$n]
            ];

          $msg.=$this->quickUpdate($req,$food,$branch,$department);
          $n++;
        }

        if($msg)  return back()->with('success', $msg);
        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, Food $food, Branch $branch, Department $department = null)
    {
    //
        $functions = new FunctionController;
        $result = Food::where([['name', $request->name],['branch_id', $branch->id]])->first();
        $name = $food->name;

        if(!$result) $food->name = $request->name;

        $food->price = $request->price ;
        $food->stock = filled($request->stock) ?  $request->stock : 0 ;
        $food->details = filled($request->details) ?  $request->details : null ;
        $food->slug = str_replace(" ","-",trim($food->name));

        try{
          $food->save();
        }
        catch(\Illuminate\Database\QueryException $e){
            return $food->name."System Error changes could not be saved, ";
        }

        if($result AND $name != $request->name){
          return ' '.$name.' was not changed to '.$request->name.'  to avoid duplicates, ';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate food if there are doubles, due to presence in all the branches
        $food = $functions->matchToBranch($branch, $food,'foods','food');
        $name = $food->name;

        try{
          $food->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
            return redirect(($functions->getReturnLink($branch,$department)))->with('success','the food: '.$name. ' cannot be deleted, since it is in use');
        }

        return redirect(($functions->getReturnLink($branch,$department)))->with('success','the food: '.$name. ' has been deleted successfully');
    }
}
