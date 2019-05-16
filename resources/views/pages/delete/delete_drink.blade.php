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
    $drink = isset($drink)? $drink:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection


@section('page')
<div class="card">
  <form method="POST"  action="{{url($functions->getLink('drinks',$drink,$branch,$department))}}" enctype="multipart/form-data">
    @csrf
    {{method_field('DELETE')}}

    <div class="card-header system-text">
      <i class="icon ti ti-trash"> </i>
      <span class='system-text text'> Delete {{ $drink->name }} from the branch </span>
    </div>

    <div class="card-body">
      
          @include('partials.messages')

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="drinkName"> Name </span>
              </div>
              <input readonly type="text" name="name" class="form-control" value="{{ $drink->name }}" aria-label="branchname" aria-describedby="basic-addon1">
          </div>

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="drinkName">Price </span>
              </div>
              <input readonly type="number" name="price" value="{{$drink->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
          </div>


          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01"> Drink type </label>
              </div>
              <select readonly name="drink_type_id" class="form-control" id="drinkTypeId">
                <option value="" selected> None </option>

                @foreach($drink_types as $drink_type)
                  <?php
                     $selected = ($drink_type->id == $drink->drink_type_id) ?  'selected':'';
                  ?>
                  <option value="{{$drink_type->id}}" {{$selected}}> {{$drink_type->name}} </option>
                @endforeach

              </select>
          </div>

          @if($drink->stock)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="drinkName">Available in Stock </span>
                </div>
                <input readonly type="number" name="stock" value="{{$drink->stock}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
            </div>
          @endif

          @if($drink->crate_size_id)
          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Crate Size </label>
              </div>
              <select readonly name="crate_size_id" class="form-control" id="drinkTypeId">
                <option value="" selected> None </option>

                @foreach($crate_sizes as $crate_size)
                  <?php
                     $selected = ($crate_size->id == $drink->crate_size_id) ?  'selected':'';
                  ?>
                  <option value="{{$crate_size->id}}" {{$selected}}> {{$crate_size->size}} </option>
                @endforeach

              </select>
          </div>
          @endif

          @if($drink->crate_price)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="drinkName">Crate Price </span>
                </div>
                <input readonly type="number" name="crate_price" value="{{$drink->crate_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
            </div>
          @endif

          @if($drink->single_price)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="drinkName">Single Price </span>
                </div>
                <input readonly type="number" name="single_price" value="{{$drink->single_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
            </div>
          @endif


          @if($drink->details)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Drink Details </span>
                </div>
                <textarea readonly name="details" class="form-control" aria-label="With textarea">{{$drink->details}}</textarea>
            </div>
          @endif

          @if(count($drink->pictures))
            <div class="center_txt">
              <div class="images-display" id="drinkImagesDisplayOld">

                @foreach($drink->pictures as $pic)
                <div class="thumbnail">
                  <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                </div>
                @endforeach

              </div>
            </div>
          @endif

    </div>

    <div class="card-footer input-group field center-text flex-container flex-between">
      <a href="{{ $functions->getReturnLink($branch,$department)}}" >
        <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
      </a>
      <input  class="btn btn-primary" type="submit"  value="Delete this Drink">
    </div>


  </form>
  </div>

@endsection
