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
    $nav_bar_items += ['model' => 'rooms'];
    $nav_bar_items += ['instance' => $room];

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
          <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> Rooms </span>
        </div>

        <div class="card-body">

            @include('partials.messages')

            <div class="menu modal-header" id="editDepartment">
              <a class="menu-option" >
                <i class="icon fi ti-wand "> </i>
                <span class="system-text"> Option 1 </span>
              </a>
            </div>

            <div class="modal-body fit-child">

                <h5 class="modal-header category text">
                    <?php echo $themify_icons['rooms']['tag'] ?>  {{ $room->name }}
                </h5>

                <div class=" model model-show ">
                  <div class="card-body">

                    <p class="card-text text">
                       <?php echo $themify_icons['price']['tag'] ?>
                       <span> Price in an ordinary day is   </span>
                       <span class="strong money"> {{$room->price}} </span>
                    </p>

                    <p class="card-text text">
                       <?php echo $themify_icons['price']['tag'] ?>
                       <span> Price in an holiday day is   </span>
                       <span class="strong money"> {{$room->holiday_price}} </span>
                    </p>

                    <br>
                    <h6 class="sub-category"> Features </h6>
                    <hr>

                    <p class="card-text text">
                       <?php echo $themify_icons['room-type']['tag'] ?>
                       <span> This is a </span>
                       <span class='strong' > {{$room->roomType->name}} </span> <span> Room </span>
                    </p>

                    <p class="card-text text">
                      <?php
                         $i=$room->floor;
                         if($i==0) $nth = 'Ground';
                         elseif($i==1)  $nth = 'st';
                         elseif($i==2) $nth = 'nd';
                         elseif($i==3) $nth = 'rd';
                         else $nth = 'th';
                       ?>
                       <?php echo $themify_icons['floor']['tag'] ?>
                       <span> It is located on the   </span>
                       @if($i) <span class='strong' >  {{$room->floor.$nth}} Floor </span> @endif
                       @if(!$i) <span class='strong' >  {{$nth}} Floor </span> @endif
                    </p>

                    @if($room->fan)
                    <p class=" card-text text has-fan  ">
                        <?php echo $themify_icons['fan']['tag'] ?>
                        <span> It has a </span>
                        <span class="strong"> Fan </span>
                    </p>
                    @endif

                    @if($room->ac)
                    <p class="card-text text has-ac">
                        <?php echo $themify_icons['ac']['tag'] ?>
                        <span> It has an </span>
                        <span class="strong"> AC </span>
                    </p>
                    @endif

                    <br>
                    <h6 class="sub-category"> Status </h6>
                    <hr>

                    @if($room->active)
                    <p>
                      <?php echo $themify_icons['active']['tag'] ?>
                      <span> The room is currently active </span>
                    </p>
                    @endif
                    @if(!$room->active)
                    <p>
                      <?php echo $themify_icons['inactive']['tag'] ?>
                      <span> The room is currently not active </span>
                    </p>
                    @endif

                    <p class="card-text text">
                        <?php echo $themify_icons['count']['tag'] ?>
                        <span> It has been comissioned  </span>
                        <span class="strong"> {{ $room->count }}</span> <span>times</span>
                    <p>

                    @if($room->details)

                    <p class="card-text text">
                        <?php echo $themify_icons['details']['tag'] ?>
                        <span class=""> {{ $room->details }}</span>
                    <p>
                    @endif


                    @if(count($room->remarks->where('solved',0)))
                    <br>
                    <h6 class="sub-category"> Remarks </h6>
                    <hr>
                        @foreach($room->remarks->where('solved',0) as $remark)
                        <p class="card-text text">
                            <?php echo $themify_icons['details']['tag'] ?>
                            <span class="text"> {{ $remark->remark }}</span>
                        <p>
                        @endforeach
                    @endif

                  </div>
                </div>

                @if(count($room->pictures))
                <br>
                <h6 class="sub-category"> Room Images </h6>
                <hr>
                <div class="center_txt">
                  <div class="images-display" id="roomImagesDisplayOld">
                    @foreach($room->pictures as $pic)
                    <div class="thumbnail">
                      <a href="{{ $pic->picture }}" class='js-smartphoto ' data-caption="{{ $pic->details }}" data-id="{{ $pic->id }}" data-group="{{ $room->name}}">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </a>
                    </div>
                    @endforeach
                  </div>
                </div>
                @endif

          </div>
      </div>

      <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
      </div>

</div>
@endsection
