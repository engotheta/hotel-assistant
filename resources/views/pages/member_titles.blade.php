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
      <span class='system-text text'>Edit  Member's Titles/Positions/Roles  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')

        <?php
          $department = isset($department)? $department:null;
          $branch = isset($branch)? $branch:null;
         ?>

      <h4 class="section-title"> Member Titles </h4>

      <form method="POST" name="member_titles" action="{{url($functions->getLink('titles',null,$branch,$department).'/update-many')}}" enctype="multipart/form-data">
        @csrf

        <ul class="list-group list-group-flush">

            <?php   $n=0; ?>
            @forelse($titles as $title)
              <?php $n++; ?>
                <li class="list-group-item">

                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                         <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           {{$n}}
                         </button>
                         <div class="dropdown-menu">
                           <a class="dropdown-item toggle-editable" data-inputs="titleField{{$n}}">Edit</a>
                           <a class="dropdown-item" href="{{url($functions->getIdLink('titles',$title->id,$branch,$department).'/destroy')}}">Delete</a>
                         </div>
                       </div>
                      <input hidden type="number" name="id[]" value="{{$title->id}}">
                      <input readonly type="text" name="name[]" id="titleName{{$n}}" class="form-control titleField{{$n}} room-type-name" value="{{ $title->name }}" aria-label="titleName" aria-describedby="basic-addon1">
                      <div class="input-group-append">
                          <span class="input-group-text btn system-text" id="titleName" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                            details
                          </span>
                      </div>
                  </div>

                  <div id="collapseDetail{{$n}}" class="collapse">
                    <textarea readonly name="details[]" id="titleDetails{{$n}}" class=" form-control titleField{{$n}} room-type-details" aria-label="With textarea">{{$title->details}}</textarea>
                  </div>

                </li>


            @empty

            @endforelse

          </ul>


          <hr class="dividing-line transparent">

          <div class="input-group field center-text flex-container flex-between">
            <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#addNewTitle" aria-expanded="false" aria-controls="collapseNewRoomTYpe" >
              Add New Title!
            </button>
            <a href="{{ url($functions->getReturnLink($branch,$department))}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>

        </form>

    </div>
    <div class="card-footer collapse"  id="addNewTitle" >

      <h4 class="section-title system-text"> Add a New Title</h4>

      <form method="POST" action="{{url($functions->getLink('titles',null,$branch,$department))}}" enctype="multipart/form-data">
        @csrf
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomName"> Name </span>
                </div>
                <input  type="text" name="name" class="form-control" placeholder="Title name" aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Title Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>

            <hr class="dividing-line">

            <div class="input-group field center-text flex-container flex-between">
              <input class="btn btn-primary" type="submit"  value="Save The New Title">
            </div>
      </form>
    </div>
  </div>
@endsection
