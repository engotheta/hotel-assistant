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
  <form method="POST"  action="{{$functions->getLink('venues',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="modal-header">
            <h5 class="modal-title system-text " id="addVenue">Add a new Venue to {{ $branch->name}}'s branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="VenueName"> Name </span>
                </div>
                <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                <input required type="text" name="name" class="form-control" placeholder="Venue's name" aria-label="branchname" aria-describedby="basic-addon1">
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
                    ?>
                    <option value="{{$i}}"> {{$i.$nth}} Floor</option>
                    <?php }?>
                </select>
            </div>


            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="VenueWeekdayPrice">Weekday Price </span>
                </div>
                <input required type="number" name="weekday_price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="VenueWeekendPrice">Weekend Price </span>
                </div>
                <input required type="number" name="weekend_price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="VenueCapacity">Venue's people Capacity </span>
                </div>
                <input required type="number" name="capacity" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="venueFan">Has Fan </span>
                </div>
                <select required name="fan" class="form-control"  >
                      <option value="1"> Yes </option>
                      <option value="0"> No </option>
                </select>
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomAc">Has Air Condition </span>
                </div>
                <select required name="ac" class="form-control"  >
                      <option value="1"> Yes </option>
                      <option value="0"> No </option>
                </select>
            </div>

            <h4 class="section-title"> Optional Fields </h4>
            <hr class="dividing-line">

            <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="images">Venue's Pictures</label>
              </div>
              <div class="custom-file">
                <input name="images[]" id="VenueImages" type="file" class="thumbnail-creator custom-file-input"
                 data-multiple-caption="{count} files selected" data-display="#VenueImagesDisplay"
                 data-event="onchange"  multiple>
              </div>
            </div>
            <div class="center_txt">
              <div class="images-display" id="VenueImagesDisplay"></div>
            </div>

            <div class="input-group field">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Venue Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>

          </div>

        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Add The Venue">
        </div>

    </form>
</div>
@endsection
