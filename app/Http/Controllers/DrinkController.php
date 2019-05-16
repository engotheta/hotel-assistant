<?php

namespace App\Http\Controllers;

use App\Drink;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Branch  $branch = null, Department $department = null)
    {
        $drinks = ($branch)? $branch->drinks->sortBy('drink_type_id')->sortBy('branch_id') : Drink::all()->sortBy('drink_type_id')->sortBy('branch_id');

        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.index.index_drinks',$functions->getParameters($branch,$department,$drinks,'drinks'));

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
         return view('pages.add.add_drink',$functions->getParameters($branch,$department));
     }

     public function add(Branch $branch = null, Department $department = null )
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.add_drink',$functions->getParameters($branch,$department));
    }

    public function createMany(Branch $branch = null, Department $department = null )
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.add.many.add_many_drinks',$functions->getParameters($branch,$department));
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch $branch = null, Department $department = null )
    {
        //
        $result = Drink::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return back()->with('success',$request->name.'  already exists in this branch as a drink');

        $drink = new Drink;
        $drink->name = $request->name;
        $drink->branch_id = $request->branch_id;
        $drink->drink_type_id = $request->drink_type_id ;
        $drink->price = $request->price ;
        $drink->stock = filled($request->stock) ?  $request->stock : 0 ;
        $drink->crate_price = filled($request->crate_price) ?  $request->crate_price : null ;
        $drink->single_price = filled($request->single_price) ?  $request->single_price : null ;
        $drink->crate_size_id = filled($request->crate_size_id) ?  $request->crate_size_id : null ;
        $drink->details = filled($request->details) ?  $request->details : null ;
        $drink->slug = str_replace(" ","-",trim($drink->name));

        try{
          $drink->save();
          $pic = new PictureController;
          $pic->storeAndAttach($request,$drink,'A picture for drink '.$drink->name);
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success',$drink->name.' Drink could not be added');
        }

        $functions = new FunctionController;
        return redirect($functions->getReturnLink($branch,$department))->with('success',$drink->name.' has been successfully added as drink to the branch');

    }


    public function storeMany(Request $request, Branch $branch, Department $department = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');

          $names = count($request->name) ;
          $prices = count($request->name) ;
          $drink_type_ids = count($request->name) ;
          $msg = null;
          $n = 0;

          if(!($names == $prices && $prices == $drink_type_ids))  return back()->with('success','System missmatch drinks could not be added');

          foreach ($request->name as $name) {
            $req = (object)[
                'name'=>$request->name[$n],
                'branch_id'=>$branch->id,
                'price'=>$request->price[$n],
                'stock'=>$request->stock[$n],
                'drink_type_id'=>$request->drink_type_id[$n],
                'crate_size_id'=>$request->crate_size_id[$n],
                'single_price'=>$request->single_price[$n],
                'crate_price'=>$request->crate_price[$n],
                'details'=>$request->details[$n]
              ];

            $msg.=$this->quickStore($req);
            $n++;
          }

          if($msg) return redirect($functions->getReturnLink($branch,$department))->with('success',$msg);
          return redirect($functions->getReturnLink($branch,$department))->with('success','new drinks were added successfully');
    }

    public function quickStore($request)
    {
        //
        $result = Drink::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return $request->name.' skipped because already exists in this branch as a drink, ';

        $drink = new Drink;
        $drink->name = $request->name;
        $drink->branch_id = $request->branch_id;
        $drink->drink_type_id = $request->drink_type_id ;
        $drink->price = $request->price ;
        $drink->stock = filled($request->stock) ?  $request->stock : 0 ;
        $drink->crate_price = filled($request->crate_price) ?  $request->crate_price : null ;
        $drink->single_price = filled($request->single_price) ?  $request->single_price : null ;
        $drink->crate_size_id = filled($request->crate_size_id) ?  $request->crate_size_id : null ;
        $drink->details = filled($request->details) ?  $request->details : null ;
        $drink->slug = str_replace(" ","-",trim($drink->name));

        try{
          $drink->save();
        }

        catch(\Illuminate\Database\QueryException $e){
          return 'System Error '.$request->name.' could be added, ';
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function show(Drink $drink, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $drink = $functions->matchToBranch($branch, $drink,'drinks','drink');
        return view('pages.view.view_drink',$functions->getParameters($branch,$department,$drink,'drink'));

    }

    public function showToDelete(Drink $drink, Branch $branch=null, Department $department  =null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $drink = $functions->matchToBranch($branch, $drink,'drinks','drink');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_drink',$functions->getParameters($branch,$department,$drink,'drink'));
    }

    public function showDrinkVariables(Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles in the whole hotel
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.drinks_variables',$functions->getParameters($branch,$department));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function edit(Drink $drink, Branch  $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $drink = $functions->matchToBranch($branch, $drink,'drinks','drink');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.edit_drink',$functions->getParameters($branch,$department,$drink,'drink'));
    }

    public function editMany( Branch  $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.edit.many.edit_many_drinks',$functions->getParameters($branch,$department));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drink $drink, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        $result = Drink::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        $name = $drink->name;

        if(!$result) $drink->name = $request->name;

        $drink->drink_type_id = $request->drink_type_id ;
        $drink->price = $request->price ;
        $drink->stock = filled($request->stock) ?  $request->stock : null ;
        $drink->crate_price = filled($request->crate_price) ?  $request->crate_price : null ;
        $drink->single_price = filled($request->single_price) ?  $request->single_price : null ;
        $drink->crate_size_id = filled($request->crate_size_id) ?  $request->crate_size_id : null ;
        $drink->details = filled($request->details) ?  $request->details : null ;
        $drink->slug = str_replace(" ","-",trim($drink->name));

        try{
          $drink->save();
          $pic = new PictureController;
          $pic->storeAndAttach($request,$drink,'A picture for '.$drink->name);
        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success', 'System Error while saving the changes');
        }

        if($name != $drink->name){
            return redirect($functions->getReturnLink($branch,$department))->with('success',$drink->name.' changes been successfully saved');
        }

        return back()->with('success',$drink->name.' changes been successfully saved');
    }

    public function updateMany(Request $request, Branch $branch, Department $department = null)
    {
        //
        $ids = count($request->id) ;
        $names = count($request->name) ;
        $prices = count($request->price);
        $stocks = count($request->stock);
        $n = 0;
        $msg = '';

        if(!($ids == $names && $names == $prices && $prices == $stocks)) return back()->with('success','changes could not be saved');

        foreach ($request->id as $id) {
          $drink = Drink::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'id'=>$request->id[$n],
              'stock'=>$request->stock[$n],
              'price'=>$request->price[$n],
              'drink_type_id'=>$request->drink_type_id[$n],
              'crate_size_id'=>$request->crate_size_id[$n],
              'crate_price'=>$request->crate_price[$n],
              'single_price'=>$request->single_price[$n],
              'details'=>$request->details[$n],
            ];

          $msg.=$this->quickUpdate($req,$drink,$branch,$department);
          $n++;
        }

        if($msg)  return back()->with('success', $msg);
        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, Drink $drink, Branch $branch, Department $department = null)
    {
    //
        $functions = new FunctionController;
        $result = Drink::where([['name', $request->name],['branch_id', $branch->id]])->first();
        $name = $drink->name;

        if(!$result) $drink->name = $request->name;

        $drink->drink_type_id = $request->drink_type_id ;
        $drink->price = $request->price ;
        $drink->stock = filled($request->stock) ?  $request->stock : null ;
        $drink->crate_price = filled($request->crate_price) ?  $request->crate_price : null ;
        $drink->single_price = filled($request->single_price) ?  $request->single_price : null ;
        $drink->crate_size_id = filled($request->crate_size_id) ?  $request->crate_size_id : null ;
        $drink->details = filled($request->details) ?  $request->details : null ;
        $drink->slug = str_replace(" ","-",trim($drink->name));

        try{
          $drink->save();
        }
        catch(\Illuminate\Database\QueryException $e){
            return $drink->name."System Error changes could not be saved, ";
        }

        if($result AND $name != $request->name){
          return ' '.$name.' was not changed to '.$request->name.'  to avoid duplicates, ';
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function destroy(Drink $drink, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $drink = $functions->matchToBranch($branch, $drink,'drinks','drink');
        $name = $drink->name;

        try{
          $drink->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return redirect(($functions->getReturnLink($branch,$department)))->with('success','the drink: '.$name. ', cannot be deleted, since it is in use');
        }

        return redirect(($functions->getReturnLink($branch,$department)))->with('success','the drink: '.$name. ', has been deleted successfully');
    }
}
