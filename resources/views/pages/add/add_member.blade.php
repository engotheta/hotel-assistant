<?php

    $nav_bar_items = ['hotel'=>$hotel];

    if(isset($department)){
      $scope = 'department';
    }elseif(isset($branch)){
      $scope = 'branch';
    }else{
      $scope = 'home';
    }

    if(isset($branch)) $nav_bar_items += ['branch' => $branch];
    if(isset($department)) $nav_bar_items += ['department' => $department];

    $department = isset($department)? $department:null;
    $branch = isset($branch)? $branch:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">
  <form method="POST"  action="{{$functions->getLink('members',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="menu modal-header" id="editDepartment">
      <a class="menu-option" href="{{url($functions->getLink('members',null,$branch,$department).'/add-many')}}">
        <i class="icon fi ti-wand "> </i>
        <span class="system-text"> Add Many  </span>
      </a>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">
              Add a new Member to {{ $branch->name}}'s branch
            </h5>
          </div>

          <div class="modal-body">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="memberName"> Name </span>
                    </div>
                    <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                    <input required type="text" name="name" class="form-control" placeholder="Member Full name" aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Gender</label>
                    </div>
                    <select required name="gender" class="custom-select" id="departmentContactPersonId">
                      <option value="male" selected> Male </option>
                      <option value="female"> Female </option>
                    </select>
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Member Title</label>
                    </div>
                    <select name="title_id" class="custom-select" id="departmentContactPersonId">
                      @foreach($titles as $title)
                      <option value="{{$title->id}}"> {{$title->name}} </option>
                      @endforeach
                    </select>
                </div>

                <small> Members role in relation to this system usage privelages</small>
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Member Role</label>
                    </div>
                    <select name="role_id" class="custom-select" id="departmentContactPersonId">
                      @foreach($roles as $role)
                      <option value="{{$role->id}}"> {{$role->name}} </option>
                      @endforeach
                    </select>
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="memberName"> Salary </span>
                    </div>
                    <input required type="number" name="salary" class="form-control" placeholder="amount of salary" aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <h4 class="section-title"> Optional Fields </h4>
                <hr class="dividing-line">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Department</label>
                    </div>
                    <select name="department_id" class="custom-select" id="departmentContactPersonId">
                      <option value="" selected> None </option>
                      @foreach($departments as $dep)
                      <option value="{{$dep->id}}"> {{$dep->name}} </option>
                      @endforeach
                    </select>
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="branchAddressId"> Member's Address  </span>
                    </div>
                    <input type="text" name="address" class="form-control"  aria-label="floor" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="Birth"> Date of Birth </span>
                    </div>
                    <input  type="date" name="birth" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="phoneNumber"> Phone number </span>
                    </div>
                    <input  type="text" name="phone" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="email"> Email </span>
                    </div>
                    <input  type="email" name="email" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="images">Member's Pictures</label>
                  </div>
                  <div class="custom-file">
                    <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                     data-multiple-caption="{count} files selected" data-display="#memberImagesDisplay"
                     data-event="onchange"  multiple>
                  </div>
                </div>

                <div class="center_txt">
                  <div class="images-display" id="memberImagesDisplay"></div>
                </div>

            </div>
        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{ $functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Add member to The Branch">
        </div>

    </form>
</div>
@endsection
