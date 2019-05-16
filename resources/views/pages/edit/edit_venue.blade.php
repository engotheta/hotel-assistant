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
    $nav_bar_items += ['model' => 'venues'];
    $nav_bar_items += ['instance' => $venue];    

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
        {{method_field('PUT')}}

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit  {{ $venue->name }}'s information  </span>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="venueName"> Name </span>
                  </div>
                  <input  type="text" name="name" class="form-control" value="{{ $venue->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="VenueFloor">the Venue is on floor </span>
                  </div>
                  <select required name="floor" class="form-control"  >
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
                  <input required type="number" name="weekday_price" value="{{$venue->weekday_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="venueName">Weekend Price </span>
                  </div>
                  <input required type="number" name="weekend_price" value="{{$venue->weekend_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="VenueCapacity">Venue's people Capacity </span>
                  </div>
                  <input required type="number" value="{{$venue->capacity}}" name="capacity" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomFan">Has Fan </span>
                  </div>
                  <select required name="fan" class="form-control"  >
                    <option value="1" <?php echo $selected = ($venue->fan) ? "selected":'';?>> Yes </option>
                    <option value="0" <?php echo $selected = (!$venue->fan) ? "selected":'';?>> No </option>
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomAc">Has Air Condition </span>
                  </div>
                  <select required name="ac" class="form-control"  >
                      <option value="1" <?php echo $selected = ($venue->ac) ? "selected":'';?>> Yes </option>
                      <option value="0" <?php echo $selected = (!$venue->ac) ? "selected":'';?>> No </option>
                  </select>
              </div>

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">


              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Venue Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea">{{$venue->details}}</textarea>
              </div>

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Venue's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#venueImagesDisplay"
                   data-event="onchange"  multiple>
                </div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="venueImagesDisplay"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="venueImagesDisplayOld">
                  @foreach($venue->pictures as $pic)
                  <div class="thumbnail">
                    <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                  </div>
                  @endforeach
                </div>
              </div>

        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{ url($functions->getReturnLink($branch,$department))}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Save Changes">
        </div>

    </form>
</div>
@endsection
