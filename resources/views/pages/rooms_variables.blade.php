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
    $nav_bar_items += ['model' => 'rooms-variables'];

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
    <div class="card-header system-text">
      <i class="icon ti ti-pencil"> </i>
      <span class='system-text text'>Edit  the Rooms Variables  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')

      <?php
        $department = isset($department)? $department:null;
        $branch = isset($branch)? $branch:null;
       ?>

      <h4 class="section-title"> Room Types</h4>

      <form method="POST" name="room_types" action="{{$functions->getLink('room-types',null,$branch,$department).'/update-many'}}" enctype="multipart/form-data">
        @csrf

        <ul class="list-group list-group-flush">

            <?php   $n=0; ?>
            @forelse($room_types as $room_type)
              <?php $n++; ?>
                <li class="list-group-item">

                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                         <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           {{$n}}
                         </button>
                         <div class="dropdown-menu">
                           <a class="dropdown-item toggle-editable" data-inputs="roomTypeField{{$n}}">Edit</a>
                           <a class="dropdown-item" href="{{$functions->getIdLink('room-types',$room_type->id,$branch,$department).'/destroy'}}">Delete</a>
                         </div>
                       </div>
                      <input hidden type="number" name="id[]" value="{{$room_type->id}}">
                      <input readonly type="text" name="name[]" id="roomTypeName{{$n}}" class="form-control roomTypeField{{$n}} room-type-name" value="{{ $room_type->name }}" aria-label="branchname" aria-describedby="basic-addon1">
                      <div class="input-group-append">
                          <span class="input-group-text btn system-text" id="roomName" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                            details
                          </span>
                      </div>
                  </div>

                  <div id="collapseDetail{{$n}}" class="collapse">
                    <textarea readonly name="details[]" id="roomTypeDetails{{$n}}" class=" form-control roomTypeField{{$n}} room-type-details" aria-label="With textarea">{{$room_type->details}}</textarea>
                  </div>

                </li>


            @empty

            @endforelse

          </ul>

          <hr class="dividing-line transparent">

          <div class="input-group field center-text flex-container flex-between">
            <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#addNewRoomType" aria-expanded="false" aria-controls="collapseNewRoomTYpe" >
              Add New Type!
            </button>
            <a href="{{ $functions->getReturnLink($branch,$department)}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>

        </form>

    </div>
    <div class="card-footer collapse"  id="addNewRoomType" >

      <h4 class="section-title system-text"> Add a new Room Type</h4>

      <form method="POST" action="{{$functions->getLink('room-types',null,$branch,$department)}}" enctype="multipart/form-data">
        @csrf
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomName"> Name </span>
                </div>
                <input  type="text" name="name" class="form-control" placeholder="room type name" aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Room type Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>

            <hr class="dividing-line">

            <div class="input-group field center-text flex-container flex-between">
              <input class="btn btn-primary" type="submit"  value="Save The New Room Type">
            </div>
      </form>
    </div>
  </div>
@endsection
