<?php
  $nav_bar_items = ['hotel'=>$hotel];
  $nav_bar_items += ['branch' => $branch];
  if(isset($department)) $nav_bar_items += ['department' => $department];
  $scope = (isset($department))? 'department':'branch';
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
      <span class='system-text text'>Mass Edit the rooms in stock  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')
      <?php
        $department = isset($department)? $department:null;
        $branch = isset($branch)? $branch:null;
       ?>

      <h4 class="section-title modal-header"> Rooms </h4>
      <form method="POST" name="rooms" action="{{url($functions->getLink('rooms',null,$branch,$department).'/update-many')}}" enctype="multipart/form-data">
        @csrf
        <ul class="list-group list-group-flush field-group-list fit-child fit-parent">
            <li class="field-fit-child field-group edit-rooms-field-group fit-parent">
              <div class="name-field center-text"> # Name</div>
              <div class="fan-field center-text"> Fan </div>
              <div class="ac-field center-text"> Ac </div>
              <div class="price-field center-text"> Price</div>
            </li>
            <?php   $n=0; ?>
            @forelse($rooms as $room)
              <?php $n++; ?>
                <li class="list-group-item field-group-item fit-child fit-parent">
                  <div class="input-group field-group edit-rooms-field-group field mb-3 input-group-sm">

                      <div class="name-field  input-group-sm input-group-prepend ">
                         <button class="  btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <small> {{$n}} </small>
                         </button>
                         <div class="dropdown-menu">
                           <a class="dropdown-item toggle-editable" data-inputs="roomField{{$n}}">
                             Toggle Edit
                           </a>
                           <a class="dropdown-item" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                             Toggle Extras
                           </a>

                         </div>
                         <input readonly type="text" name="name[]"  class="form-control no-radius roomField{{$n}} room-name" value="{{ $room->name }}" aria-label="branchname" aria-describedby="basic-addon1">
                       </div>
                      <input required hidden type="number" name="id[]" value="{{$room->id}}">
                      <select required name="fan[]" class="form-control fan-field"  >
                        <option value="1" <?php echo $selected = ($room->fan) ? "selected":'';?>> Yes </option>
                        <option value="0" <?php echo $selected = (!$room->fan) ? "selected":'';?>> No </option>
                      </select>
                      <select required name="ac[]" class="form-control ac-field"  >
                          <option value="1" <?php echo $selected = ($room->ac) ? "selected":'';?>> Yes </option>
                          <option value="0" <?php echo $selected = (!$room->ac) ? "selected":'';?>> No </option>
                      </select>

                      <input required type="text" name="price[]" class="form-control price-field  room-name" value="{{ $room->price }}" aria-label="branchname" aria-describedby="basic-addon1">

                  </div>
                  <div id="collapseDetail{{$n}}" class="collapse">

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01"> Room type </label>
                          </div>
                          <select required name="room_type_id[]" class="custom-select" id="roomTypeId">
                            <option value="" selected> None </option>

                            @foreach($room_types as $room_type)
                              <?php
                                 $selected = ($room_type->id == $room->room_type_id) ?  'selected':'';
                              ?>
                              <option value="{{$room_type->id}}" {{$selected}}> {{$room_type->name}} </option>
                            @endforeach

                          </select>
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text system-text" id="RoomFloor">the Room is on floor </span>
                          </div>
                          <select required name="floor[]" class="form-control"  >
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

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text system-text" id="roomHolidayPrice">Holiday Price </span>
                          </div>
                          <input required type="number" name="holiday_price[]" value="{{$room->holiday_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"> Room Details </span>
                          </div>
                          <textarea name="details[]" class="form-control" aria-label="With textarea">{{$room->details}}</textarea>
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

                      <h5 class="center-text">
                          <a href="{{$functions->getLink('rooms',$room,$branch,$department).'/edit'}}" > Add Pictures </a>
                      </h5>
                      <hr class="dividing-line">


                  </div>
                </li>
            @empty
            @endforelse
          </ul>
          <hr class="dividing-line transparent">
          <div class="input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>
        </form>
    </div>


  </div>
@endsection
