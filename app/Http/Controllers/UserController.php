<?php

namespace App\Http\Controllers;

use App\User;
use App\Address;
use App\Branch;
use App\Department;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Branch  $branch = null, Department $department = null)
    {
        //
        $members = ($branch)? $branch->users->sortBy('gender')->sortBy('branch_id') : User::all()->sortBy('gender')->sortBy('branch_id');

        $functions = new FunctionController;
        //set the right department if there are doubles
        if($department) $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.index.index_members ',$functions->getParameters($branch,$department,$members,'members'));
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
         return view('pages.add.add_member',$functions->getParameters($branch,$department));

     }

     public function createMany(Branch $branch = null, Department $department = null )
     {
         $functions = new FunctionController;
         //set the right department if there are doubles
         $department = $functions->matchToBranch($branch, $department,'departments','department');
         //filter some contents for branch or department depending on the url
         return view('pages.add.many.add_many_members',$functions->getParameters($branch,$department));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Branch  $branch = null, Department $department = null)
    {
        //
        $member = new User;
        $member->name = $request->name;
        $member->gender = $request->gender;
        $member->salary = $request->salary;
        $member->role_id = $request->role_id;
        $member->title_id = $request->title_id;
        $member->birth = $request->birth;
        $member->branch_id = $request->branch_id;
        $member->department_id = isset($request->department_id) ? $request->department_id:null;
        $member->phone = isset($request->phone) ? $request->phone:null;
        $member->email = isset($request->email) ? $request->email:null;
        $member->slug = str_replace(" ","-",trim($member->name));

        try{
          if(isset($request->address)){
              $result = Address::where('name', $request->address)->first();

              if(!$result){
                $address = new Address;
                $address->name = $request->address;
                $address->save();
              }else{
                $address = $result;
              }

              $address->branches()->save($member);
          }else $member->save();

          $pic = new PictureController;
          $pic->storeAndAttach($request,$member,'A picture of '.$member->name);

        }

        catch(\Illuminate\Database\QueryException $e){
            return back()->with('success', $member->name.'  has not been added to members due to system Error');
        }

        $functions = new FunctionController;
        return redirect($functions->getReturnLink($branch,$department))->with('success', $member->name.'  has been successfully added to members');
    }

    public function storeMany(Request $request, Branch $branch, Department $department = null)
    {
          $functions = new FunctionController;
          //set the right department if there are doubles
          $department = $functions->matchToBranch($branch, $department,'departments','department');

          $names = count($request->name) ;
          $genders = count($request->gender) ;
          $roles = count($request->role_id) ;
          $msg = null;
          $n = 0;

          if(!($names == $genders && $genders == $roles))  return back()->with('success','System missmatch members could not be added');

          foreach ($request->name as $name) {
            $req = (object)[
                'name'=>$request->name[$n],
                'branch_id'=>$branch->id,
                'salary'=>$request->salary[$n],
                'role_id'=>$request->role_id[$n],
                'address'=>$request->address[$n],
                'title_id'=>$request->title_id[$n],
                'department_id'=>$request->department_id[$n],
                'email'=>$request->email[$n],
                'birth'=>$request->birth[$n],
                'gender'=>$request->gender[$n],
                'phone'=>$request->phone[$n],
              ];

            $msg.=$this->quickStore($req);
            $n++;
          }

          if($msg) return redirect($functions->getReturnLink($branch,$department))->with('success',$msg);
          return redirect($functions->getReturnLink($branch,$department))->with('success','new members were added successfully');
    }

    public function quickStore($request)
    {
        //
        $result = User::where([['name', $request->name],['branch_id', $request->branch_id]])->first();
        if($result) return $request->name.' skipped because already exists in this branch as a member, ';

        $member = new User;
        $member->name = $request->name;
        $member->gender = $request->gender;
        $member->salary = $request->salary;
        $member->role_id = $request->role_id;
        $member->title_id = $request->title_id;
        $member->birth = $request->birth;
        $member->branch_id = $request->branch_id;
        $member->department_id = isset($request->department_id) ? $request->department_id:null;
        $member->phone = isset($request->phone) ? $request->phone:null;
        $member->email = isset($request->email) ? $request->email:null;
        $member->slug = str_replace(" ","-",trim($member->name));

        try{
          if(isset($request->address)){
              $result = Address::where('name', $request->address)->first();

              if($result){
                $address = new Address;
                $address->name = $request->address;
                $address->save();
              }else{
                $address = $result;
              }

              $address->branches()->save($member);
          }else $member->save();

        }

        catch(\Illuminate\Database\QueryException $e){
          return 'System Error '.$request->name.' could be added, ';
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $member, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $member = $functions->matchToBranch($branch, $member,'members','member');
        return view('pages.view.view_member',$functions->getParameters($branch,$department,$member,'member'));

    }

    public function showMemberRoles(Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        return view('pages.member_roles',$functions->getParameters($branch,$department));
    }

    public function showToDelete(User $member, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $member = $functions->matchToBranch($branch, $member,'members','member');
        //filter some contents for branch or department depending on the url
        return view('pages.delete.delete_member',$functions->getParameters($branch,$department,$member,'member'));
    }

    public function showMemberTitles(Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        return view('pages.member_titles',$functions->getParameters($branch,$department));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $member, Branch $branch = null , Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $member = $functions->matchToBranch($branch, $member,'members','member');
        //filter some contents for branch or department depending on the url
        $parameters = $functions->getParameters($branch,$department,$member,'member');
        $parameters['branches'] = Branch::all();
        return view('pages.edit.edit_member',$parameters);
    }

    public function editMany( Branch  $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        //filter some contents for branch or department depending on the url
        $parameters = $functions->getParameters($branch,$department);
        $parameters['branches'] = Branch::all();
        return view('pages.edit.many.edit_many_members',$parameters);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Branch $branch = null, Department $department = null)
    {
        //
        $functions = new FunctionController;

        $name = $user->name;
        $member = $user;
        $member->name = $request->name;
        $member->gender = $request->gender;
        $member->salary = $request->salary;
        $member->birth = $request->birth;
        $member->role_id = $request->role_id;
        $member->title_id = $request->title_id;
        $member->branch_id = $request->branch_id;
        $member->department_id = isset($request->department_id) ? $request->department_id:null;
        $member->phone = isset($request->phone) ? $request->phone:null;
        $member->email = isset($request->email) ? $request->email:null;
        $member->slug = str_replace(" ","-",trim($member->name));

        try{
            if(isset($request->address)){
                $result = Address::where('name', $request->address)->first();

                if(!$result){
                  $address = new Address;
                  $address->name = $request->address;
                  $address->save();
                }else{
                  $address = $result;
                }

                $address->branches()->save($member);
            }else $member->save();

            $pic = new PictureController;
            $pic->storeAndAttach($request,$member,'A picture of '.$member->name);
        }

        catch(\Illuminate\Database\QueryException $e){
              return back()->with('success', $member->name.' information has failed to be changed ');
        }

        if($name != $member->name){
           return redirect($functions->getReturnLink($branch,$department))->with('success', $member->name.' information changes have been successfully saved');
        }

        return back()->with('success', $member->name.' information changes have been successfully saved');
    }

    public function updateMany(Request $request, Branch $branch, Department $department = null)
    {
        //
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');

        $names = count($request->name) ;
        $genders = count($request->gender) ;
        $roles = count($request->role_id) ;
        $msg = null;
        $n = 0;

        if(!($names == $genders && $genders == $roles))  return back()->with('success','System missmatch members could not be added');

        foreach ($request->id as $id) {
          $member = User::where('id', $id)->first();
          $req = (object)[
              'name'=>$request->name[$n],
              'branch_id'=>$branch->id,
              'salary'=>$request->salary[$n],
              'role_id'=>$request->role_id[$n],
              'address'=>$request->address[$n],
              'title_id'=>$request->title_id[$n],
              'department_id'=>$request->department_id[$n],
              'email'=>$request->email[$n],
              'birth'=>$request->birth[$n],
              'gender'=>$request->gender[$n],
              'phone'=>$request->phone[$n],
            ];

          $msg.=$this->quickUpdate($req,$member,$branch,$department);
          $n++;
        }

        if($msg)  return back()->with('success', $msg);
        return back()->with('success','changes were saved successfully');
    }

    public function quickUpdate($request, User $member, Branch $branch, Department $department = null)
    {
        //
        $functions = new FunctionController;
        $member->name = $request->name;
        $member->gender = $request->gender;
        $member->salary = $request->salary;
        $member->birth = $request->birth;
        $member->role_id = $request->role_id;
        $member->title_id = $request->title_id;
        $member->branch_id = $request->branch_id;
        $member->department_id =  $request->department_id ;
        $member->phone = $request->phone ;
        $member->email = $request->email ;
        $member->slug = str_replace(" ","-",trim($member->name));

        try{
            if(isset($request->address)){
                $result = Address::where('name', $request->address)->first();

                if(!$result){
                  $address = new Address;
                  $address->name = $request->address;
                  $address->save();
                }else{
                  $address = $result;
                }

                $address->branches()->save($member);
            }else $member->save();
        }

        catch(\Illuminate\Database\QueryException $e){
            return $drink->name."System Error changes could not be saved, ";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $member, Branch $branch = null, Department $department = null)
    {
        $functions = new FunctionController;
        //set the right department if there are doubles
        $department = $functions->matchToBranch($branch, $department,'departments','department');
        // set appropriate drink if there are doubles, due to presence in all the branches
        $member = $functions->matchToBranch($branch, $member,'members','member');

        $name = $member->name;

        try{
          $member->delete();
        }

        catch(\Illuminate\Database\QueryException $e){
          return redirect($functions->getReturnLink($branch,$department))->with('success',$name. ' cannot be deleted, since has been reference with other objects');
        }

        return redirect($functions->getReturnLink($branch,$department))->with('success',$name. ' has been deleted from the branch successfully');
    }
}
