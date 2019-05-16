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
    $venue = isset($venue)? $venue:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">
  <form method="POST"  action="{{url($functions->getLink('venues',$venue,$branch,$department))}}" enctype="multipart/form-data">
    @csrf
    {{method_field('DELETE')}}

    <div class="card-header system-text">
      <i class="icon ti ti-trash"> </i>
      <span class='system-text text'> Delete {{ $venue->name }} from the branch </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="venueName"> Name </span>
              </div>
              <input readonly type="text" name="name" class="form-control" value="{{ $venue->name }}" aria-label="branchname" aria-describedby="basic-addon1">
          </div>

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="VenueFloor">the Venue is on floor </span>
              </div>
              <select readonly name="floor" class="form-control"  >
                <option value="0" selected> Ground Floor </option>
                 <?php for($i=1; $i<=$branch->floors; $i++){

                    if($i==1){$nth = 'st';}
                    elseif($i==2){$nth = 'nd';}
                    elseif($i==3){$nth = 'rd';}
                    else{$nth = 'th';}

                    $selected = ($venue->floor == $i) ? "selected":'';
                  ?>
                  <option value="{{$i}}" {{$selected}}> {{$i.$nth}} Floor</option>
                  <?php }?>
              </select>
          </div>

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="venueName">Weekday Price </span>
              </div>
              <input readonly type="number" name="weekday_price" value="{{$venue->weekday_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
          </div>

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="venueName">Weekend Price </span>
              </div>
              <input readonly type="number" name="weekend_price" value="{{$venue->weekend_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
          </div>

          <div class="input-group field mb-3">
              <div class="input-group-prepend">
                  <span class="input-group-text system-text" id="VenueCapacity">Venue's people Capacity </span>
              </div>
              <input readonly type="number" value="{{$venue->capacity}}" name="capacity" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
          </div>

          @if($venue->details)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Venue Details </span>
                </div>
                <textarea readonly name="details" class="form-control" aria-label="With textarea">{{$venue->details}}</textarea>
            </div>
          @endif

          @if(count($venue->pictures))
            <div class="center_txt">
              <div class="images-display" id="venueImagesDisplayOld">

                @foreach($venue->pictures as $pic)
                <div class="thumbnail">
                  <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                </div>
                @endforeach

              </div>
            </div>
          @endif

    </div>

    <div class="card-footer input-group field center-text flex-container flex-between">
      <a href="{{ $functions->getReturnLink($branch,$department) }}" >
        <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
      </a>
      <input  class="btn btn-primary" type="submit"  value="Delete this Venue">
    </div>

</form>
</div>

@endsection
