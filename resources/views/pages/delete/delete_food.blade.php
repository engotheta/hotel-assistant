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
    $food = isset($food)? $food:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">

  <form method="POST"  action="{{url($functions->getLink('foods',$food,$branch,$department))}}" enctype="multipart/form-data">
    @csrf
    {{method_field('DELETE')}}

    <div class="card-header system-text">
      <i class="icon ti ti-trash"> </i>
      <span class='system-text text'> Delete {{ $food->name }} from the branch </span>
    </div>

    <div class="card-body">
      @include('partials.messages')



              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="foodName"> Name </span>
                  </div>
                  <input readonly type="text" name="name" class="form-control" value="{{ $food->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="foodName">Price </span>
                  </div>
                  <input readonly type="number" name="price" value="{{$food->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              @if($food->stock)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="foodName">Available in Stock </span>
                    </div>
                    <input readonly type="number" name="stock" value="{{$food->stock}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>
              @endif

              @if($food->details)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> Food Details </span>
                    </div>
                    <textarea readonly name="details" class="form-control" aria-label="With textarea">{{$food->details}}</textarea>
                </div>
              @endif

              @if(count($food->pictures))
                <div class="center_txt">
                  <div class="images-display" id="foodImagesDisplayOld">

                    @foreach($food->pictures as $pic)
                    <div class="thumbnail">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </div>
                    @endforeach

                  </div>
                </div>
              @endif



    </div>

    <div class="card-footer input-group field center-text flex-container flex-between">
      <a href="{{$functions->getReturnLink($branch,$department)}}" >
        <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
      </a>
      <input  class="btn btn-primary" type="submit"  value="Delete this Food">
    </div>

</form>
  </div>

@endsection
