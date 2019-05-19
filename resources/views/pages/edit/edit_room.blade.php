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
    <form method="POST"  action="{{url($functions->getLink('rooms',$room,$branch,$department))}}" enctype="multipart/form-data">
        @csrf
        {{method_field('PUT')}}

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit Room {{ $room->name }}'s information  </span>
        </div>

        <div class="menu modal-header" id="editDepartment">
          <a class="menu-option" href="{{url($functions->getLink('rooms',null,$branch,$department).'/edit-many')}}">
            <i class="icon fi ti-wand "> </i>
            <span class="system-text"> Edit Many  </span>
          </a>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomName"> Name </span>
                  </div>
                  <input  type="text" name="name" class="form-control" value="{{ $room->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Room type </label>
                  </div>
                  <select name="room_type_id" class="custom-select" id="roomTypeId">
                    <option value="" selected> None </option>
                    @foreach($room_types as $room_type)
                    <?php $selected = ($room_type->id == $room->room_type_id) ?  'selected':''; ?>
                    <option value="{{$room_type->id}}" {{$selected}}> {{$room_type->name}} </option>
                    @endforeach
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="RoomFloor">the Room is on floor </span>
                  </div>
                  <select required name="floor" class="form-control"  >
                    <option value="0" selected> Ground Floor </option>
                     <?php for($i=1; $i<=$branch->floors; $i++){
                        if($i==1){$nth = 'st';}
                        elseif($i==2){$nth = 'nd';}
                        elseif($i==3){$nth = 'rd';}
                        else{$nth = 'th';}
                        $selected = ($room->floor == $i) ? "selected":'';
                      ?>
                      <option value="{{$i}}" {{$selected}}> {{$i.$nth}} Floor</option>
                      <?php }?>
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomPrice">Price </span>
                  </div>
                  <input required type="number" name="price" value="{{$room->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomFan">Has Fan </span>
                  </div>
                  <select required name="fan" class="form-control"  >
                    <option value="1" <?php echo $selected = ($room->fan) ? "selected":'';?>> Yes </option>
                    <option value="0" <?php echo $selected = (!$room->fan) ? "selected":'';?>> No </option>
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomAc">Has Air Condition </span>
                  </div>
                  <select required name="ac" class="form-control"  >
                      <option value="1" <?php echo $selected = ($room->ac) ? "selected":'';?>> Yes </option>
                      <option value="0" <?php echo $selected = (!$room->ac) ? "selected":'';?>> No </option>
                  </select>
              </div>

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">


              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="roomHolidayPrice">Holiday Price </span>
                  </div>
                  <input required type="number" name="holiday_price" value="{{$room->holiday_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Room Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea">{{$room->details}}</textarea>
              </div>

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Room's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#roomImagesDisplay"
                   data-event="onchange"  multiple>
                </div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="roomImagesDisplay"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="roomImagesDisplayOld">
                  @foreach($room->pictures as $pic)
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
