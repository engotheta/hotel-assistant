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
    $nav_bar_items += ['model' => 'foods'];
    $nav_bar_items += ['instance' => $food];

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
          <span class="text"> Foods </span>
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
                    <?php echo $themify_icons['foods']['tag'] ?>  {{ $food->name }}
                </h5>

                <div class=" model model-show ">
                  <div class="card-body">

                    <p class="card-text text">
                       <?php echo $themify_icons['price']['tag'] ?>
                       <span> Selling Price is   </span>
                       <span class="strong money"> {{$food->price}} </span>
                    </p>


                    <br>
                    <h6 class="sub-category"> Status </h6>
                    <hr>

                    @if($food->stock)
                    <p>
                      <?php echo $themify_icons['stock']['tag'] ?>
                      <span> Current there are  </span>
                      <span class="strong"> {{ $food->stock }}</span>
                      <span> in stock </span>
                    </p>
                    @endif
                    @if(!$food->stock)
                    <p>
                      <?php echo $themify_icons['inactive']['tag'] ?>
                      <span> The food is currently not in stock </span>
                    </p>
                    @endif

                    <p class="card-text text">
                        <?php echo $themify_icons['count']['tag'] ?>
                        <span> It has been sold  </span>
                        <span class="strong"> {{ $food->count }}</span> <span>times</span>
                    <p>

                    @if($food->details)
                    <p class="card-text text">
                        <?php echo $themify_icons['details']['tag'] ?>
                        <span class=""> {{ $food->details }}</span>
                    <p>
                    @endif


                    @if(count($food->remarks->where('solved',0)))
                    <br>
                    <h6 class="sub-category"> Remarks </h6>
                    <hr>
                        @foreach($food->remarks->where('solved',0) as $remark)
                        <p class="card-text text">
                            <?php echo $themify_icons['details']['tag'] ?>
                            <span class="text"> {{ $remark->remark }}</span>
                        <p>
                        @endforeach
                    @endif

                  </div>
                </div>

                @if(count($food->pictures))
                <br>
                <h6 class="sub-category"> Food Images </h6>
                <hr>
                <div class="center_txt">
                  <div class="images-display" id="foodImagesDisplayOld">
                    @foreach($food->pictures as $pic)
                    <div class="thumbnail">
                      <a href="{{ $pic->picture }}" class='js-smartphoto ' data-caption="{{ $pic->details }}" data-id="{{ $pic->id }}" data-group="{{ $food->name}}">
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
