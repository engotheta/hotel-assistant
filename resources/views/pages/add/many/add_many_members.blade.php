<?php
    //add nav bar links items
    $nav_bar_items = ['hotel'=>$hotel];
    if(isset($branch)) $nav_bar_items += ['branch' => $branch];
    if(isset($department)) $nav_bar_items += ['department' => $department];

    //update viriables used in links
    $department = isset($department)? $department:null;
    $branch = isset($branch)? $branch:null;
 ?>

@extends('layouts.insider')
@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">
    <div class="card-header system-text">
      <i class="icon ti ti-pencil"> </i>
      <span class='system-text text'>Mass Edit the members in stock  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')
      <h4 class="section-title modal-header"> Members </h4>
      <form method="POST" name="members" action="{{$functions->getLink('members',null,$branch,$department).'/store-many'}}" enctype="multipart/form-data">
        @csrf
        <ul class="list-group list-group-flush field-group-list fit-child fit-parent">
            <li class="field-fit-child add-members-field-group fit-parent">
              <div class="name-field center-text"> # Name</div>
              <div class="gender-field center-text"> Gender</div>
              <div class="salary-field center-text"> $ </div>
            </li>

            <li class="list-group-item field-group-item  member-field fit-child fit-parent" id="createField_1">
              <div class="input-group field-group add-members-field-group field mb-3 input-group-sm">

                  <div class="name-field  input-group-sm input-group-prepend ">
                     <button class="  btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <small class="index"> 1 </small>
                     </button>
                     <div class="dropdown-menu">

                       <a class="dropdown-item collapse-detail" data-toggle="collapse" data-target="#collapseDetail_1" aria-expanded="false" aria-controls="collapseExample">
                         Toggle Optionals
                       </a>
                       <a class="dropdown-item remove-field" data-field="#createField_1" >
                         Remove this Item
                       </a>

                     </div>
                     <input required type="text" name="name[]"  class="form-control no-radius member-field_1 input member-name" placeholder="name" aria-label="branchname" aria-describedby="basic-addon1">
                   </div>

                   <select required name="gender[]" class="custom-select gender-field " id="departmentContactPersonId">
                     <option value="male" selected> M </option>
                     <option value="female"> F </option>
                   </select>
                  <input required type="number" name="salary[]" class="salary-field form-control input" placeholder="salary" aria-label="branchname" aria-describedby="basic-addon1">
              </div>
              <div id="collapseDetail_1" class="collapse">

                  <small> Members role in relation to this system usage privelages</small>
                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> Member Role</label>
                      </div>
                      <select name="role_id[]" class="custom-select" id="departmentContactPersonId">

                        @foreach($roles as $role)
                          <option value="{{$role->id}}"> {{$role->name}} </option>
                        @endforeach

                      </select>
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> Member Title</label>
                      </div>
                      <select name="title_id[]" class="custom-select" id="departmentContactPersonId">
                        @foreach($titles as $title)
                          <option value="{{$title->id}}"> {{$title->name}} </option>
                        @endforeach
                      </select>
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> Department</label>
                      </div>
                      <select name="department_id[]" class="custom-select" id="departmentContactPersonId">
                        <option value="" selected> None </option>
                            @foreach($departments as $dep)
                              <option value="{{$dep->id}}"> {{$dep->name}} </option>
                            @endforeach
                      </select>
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="branchAddressId"> Member's Address  </span>
                      </div>
                      <input type="text" name="address[]" class="form-control input"  aria-label="floor" aria-describedby="basic-addon1">
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="Birth"> Date of Birth </span>
                      </div>
                      <input  type="date" name="birth[]" class="form-control input"  aria-label="branchname" aria-describedby="basic-addon1">
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="phoneNumber"> Phone number </span>
                      </div>
                      <input  type="text" name="phone[]" class="form-control input"  aria-label="branchname" aria-describedby="basic-addon1">
                  </div>

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="email"> Email </span>
                      </div>
                      <input  type="email" name="email[]" class="form-control input"  aria-label="branchname" aria-describedby="basic-addon1">
                  </div>


              </div>
            </li>

          </ul>
          <div class="add-field clone-field center-text" data-field="#createField_1" data-type="add-member" data-update="yes" data-model="member">
            <i class="icon ti ti-plus"> </i>
          </div>

          <hr class="dividing-line transparent">
          <div class="input-group field center-text flex-container flex-between">
            <a href="{{$functions->getReturnLink($branch,$department)}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Add members">
          </div>
        </form>
    </div>


  </div>
@endsection
