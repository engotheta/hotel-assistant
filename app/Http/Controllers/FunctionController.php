<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Department;
use App\Activity;
use App\Service;


class FunctionController extends Controller
{
    //

    public function maxBranchID($model_collection){
        $max = 1;
        foreach($model_collection as $model){
          if($max <= $model->branch_id) $max = $model->branch_id;
        }
        return $max;
    }

    public function getServiceAssets(Service $service, Branch $branch){
        switch($service->name){
          case 'drinks': return $branch->drinks; break;
          case 'foods': return $branch->foods; break;
          case 'venues': return $branch->venues; break;
          case 'rooms': return $branch->rooms; break;
        }
    }

    public function isBranch($id){
        if(($bra = Branch::where('id',$id)->first())) return $bra;
        return false;
    }

    public function getLink($model = 'branches',$instance = null, Branch $branch = null, $department = null){
        if($department And $branch){
           if($instance) return '/'.$model.'/'.$instance->slug.'/'.$branch->slug.'/'.$department->slug;
           return '/'.$model.'/'.$branch->slug.'/'.$department->slug;
        }
        if($branch){
           if($instance) return '/'.$model.'/'.$instance->slug.'/'.$branch->slug;
           return '/'.$model.'/'.$branch->slug;
        }

        if(!$branch AND $instance ) return '/'.$model.'/'.$instance->slug ;
        return '/'.$model;
    }

    public function getInstanceLink($model = 'branches',$instance , Branch $branch = null, Department $department = null){
        if($department And $branch) return '/'.$model.'/'.$instance->slug.'/'.$branch->slug.'/'.$department->slug;
        if($branch) return '/'.$model.'/'.$instance->slug.'/'.$branch->slug;
        return '/'.$model;
    }

    public function getIndexLink($model = 'branches', Branch $branch = null, Department $department = null){
        if($department And $branch) return '/'.$model.'/'.$branch->slug.'/'.$department->slug;
        if($branch) return '/'.$model.'/'.$branch->slug;
        return '/'.$model;
    }

    public function getIdLink($model,$id,Branch $branch = null, Department $department = null){
        if($department And $branch) return '/'.$model.'/'.$id.'/'.$branch->slug.'/'.$department->slug;
        if($branch) return '/'.$model.'/'.$id.'/'.$branch->slug;
        return '/'.$model.'/'.$id;
    }


    public function getReturnLink(Branch $branch = null, $department = null){
        if($department){
          if($this->isDepartment($department)) return '/departments/'.$department->slug.'/'.$department->branch->slug;
          return '/activities/'.$department->slug.'/'.$department->branch->slug;
        }

        if($branch) return '/branches/'.$branch->slug;
        return '/home/';
    }

    public function goBackTo(Branch $branch = null, $department = null){
        if($department) return 'Back To '.$department->name;
        if($branch) return 'Back To '.$branch->name;
        return 'Back To Home';
    }

    public function isDepartment($department){
      //if null
      if(!$department) return null;
      //if department is a department object
      $result = Department::where([['name',$department->name],['branch_id',$department->branch_id]])->first();
      if($result) return true;
      //if not null and not department
      return false;
    }

    public function getIFDepartment(Branch $branch, $department){
        if(!$department) return null;
        //chech if its already a department object in the branches??
        if(property_exists($department,'name')){
          //if department is a department object
          $result = Department::where([['name',$department->name],['branch_id',$department->branch_id]])->first();
          if($result) return $result;
        }

        // check in departments
        $result = $branch->departments->where('slug',$department)->first();
        if($result) return $result;
        // if not found in departments check the activities
        $result = $branch->activities->where('slug',$department)->first();
        if($result) return $result;
        // if not found in  both departments and activities
        return null;
    }


    public function getParameters($branch,$department,$model=null,$model_variable=null)
    {
        //department
        if($department) {

          if($this->isDepartment($department)){
            $departmentController = new DepartmentController;
            $parameters = $departmentController->departmentParameters($department);
          }else{
            $activityController = new ActivityController;
            $parameters = $activityController->activityParameters($department);
          }

          if($model AND $model_variable) $parameters[$model_variable] = $model;
          return $parameters;
        }

        //branch
        if($branch) {
          $branchController = new BranchController;
          $parameters = $branchController->branchParameters($branch);
          if($model AND $model_variable) $parameters[$model_variable] = $model;
          return $parameters;
        }

        //home parameter
        $homeController = new HomeController;
        $parameters = $homeController->homeParameters($branch);
        if($model AND $model_variable) $parameters[$model_variable] = $model;
        return $parameters;
    }


    public function matchToBranch($branch, $model, $rel, $msg = 'item'){
        // set appropriate drink if there are doubles, due to presence in all the branches
        if($branch AND $model){
          switch ($rel){
            case 'activities': $model = $branch->activities->where('name',$model->name)->first(); break;
            case 'drinks': $model = $branch->drinks->where('name',$model->name)->first(); break;
            case 'foods': $model = $branch->foods->where('name',$model->name)->first(); break;
            case 'venues': $model = $branch->venues->where('name',$model->name)->first(); break;
            case 'rooms': $model = $branch->rooms->where('name',$model->name)->first(); break;
            case 'departments': $model = $branch->departments->where('name',$model->name)->first(); break;
          }

          if(!$model){
          //  return back()->with('success','the branch and provided '.$msg.' dont match');
          }
        }
        return $model;
    }

}
