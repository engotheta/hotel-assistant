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
  <form method="POST"  action="{{$functions->getLink('rooms',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="menu modal-header" id="editDepartment">
            <a class="menu-option" href="{{url($functions->getLink('rooms',null,$branch,$department).'/add-many')}}">
              <i class="icon fi ti-wand "> </i>
              <span class="system-text"> Add Many  </span>
            </a>
          </div>

          <div class="modal-header">
            <h5 class="modal-title system-text " id="addroom">Add a new room to {{ $branch->name}}'s branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomName"> Name </span>
                </div>
                <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                <input required type="text" name="name" class="form-control" placeholder="room's name" aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="VenueFloor">the Room's Floor </span>
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
                    <span class="input-group-text system-text" id="VenueFloor">Room Type </span>
                </div>
                <select required name="room_type_id" class="form-control"  >
                   @foreach($room_types as $room_type)
                      <option value="{{$room_type->id}}"> {{$room_type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomWeekdayPrice">Room Price </span>
                </div>
                <input required type="number" name="price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
            </div>


            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="roomFan">Has Fan </span>
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
                    <span class="input-group-text system-text" id="roomWeekendPrice">Holiday Price </span>
                </div>
                <input  type="number" name="holiday_price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="images">room's Pictures</label>
              </div>
              <div class="custom-file">
                <input name="images[]" id="roomImages" type="file" class="thumbnail-creator custom-file-input"
                 data-multiple-caption="{count} files selected" data-display="#roomImagesDisplay"
                 data-event="onchange"  multiple>
              </div>
            </div>
            <div class="center_txt">
              <div class="images-display" id="roomImagesDisplay"></div>
            </div>

            <div class="input-group field">
                <div class="input-group-prepend">
                  <span class="input-group-text"> room Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>

          </div>
      </div>

      <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{ $functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
        <input class="btn btn-primary" type="submit"  value="Add The room">
      </div>

    </form>
</div>
@endsection
