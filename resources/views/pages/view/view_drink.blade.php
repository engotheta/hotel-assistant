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

        <div class="card-header system-text">
          <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> Drinks </span>
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
                    <?php echo $themify_icons['drinks']['tag'] ?>  {{ $drink->name }}
                </h5>

                <div class=" model model-show ">
                  <div class="card-body">

                    <p class="card-text text">
                       <?php echo $themify_icons['price']['tag'] ?>
                       <span> Selling Price is   </span>
                       <span class="strong money"> {{$drink->price}} </span>
                    </p>

                    @if($drink->drinkType)
                    <p class="card-text text">
                       <?php echo $themify_icons['drink-type']['tag'] ?>
                       <span> This is a </span>
                       <span class='strong' > {{$drink->drinkType->name}} </span>
                    </p>
                    @endif

                    @if($drink->crate_size_id OR $drink->crate_price OR $drink->single_price)
                    <br>
                    <h6 class="sub-category"> properties </h6>
                    <hr>
                    @endif

                    @if($drink->crate_size_id)
                    <p class=" card-text text has-fan  ">
                        <?php echo $themify_icons['crate']['tag'] ?>
                        <span> It has a crate size of </span>
                        <span class="strong"> {{$drink->crateSize->size }} pieces </span>
                    </p>
                    @endif

                    @if($drink->crate_price)
                    <p class=" card-text text has-fan  ">
                        <?php echo $themify_icons['money']['tag'] ?>
                        <span> A single crate is </span>
                        <span class="strong money"> {{$drink->crate_price}} </span>
                    </p>
                    @endif

                    @if($drink->single_price)
                    <p class=" card-text text has-fan  ">
                        <?php echo $themify_icons['crate']['tag'] ?>
                        <span> A single piece buying price is </span>
                        <span class="strong money"> {{$drink->crate_price}} </span>
                    </p>
                    @endif

                    <br>
                    <h6 class="sub-category"> Status </h6>
                    <hr>

                    @if($drink->stock)
                    <p>
                      <?php echo $themify_icons['stock']['tag'] ?>
                      <span> Current there are  </span>
                      <span class="strong"> {{ $drink->stock }}</span>
                      <span> in stock </span>
                    </p>
                    @endif
                    @if(!$drink->stock)
                    <p>
                      <?php echo $themify_icons['inactive']['tag'] ?>
                      <span> The drink is currently not in stock </span>
                    </p>
                    @endif

                    <p class="card-text text">
                        <?php echo $themify_icons['count']['tag'] ?>
                        <span> It has been sold  </span>
                        <span class="strong"> {{ $drink->count }}</span> <span>times</span>
                    <p>

                    @if($drink->details)
                    <p class="card-text text">
                        <?php echo $themify_icons['details']['tag'] ?>
                        <span class=""> {{ $drink->details }}</span>
                    <p>
                    @endif


                    @if(count($drink->remarks->where('solved',0)))
                    <br>
                    <h6 class="sub-category"> Remarks </h6>
                    <hr>
                        @foreach($drink->remarks->where('solved',0) as $remark)
                        <p class="card-text text">
                            <?php echo $themify_icons['details']['tag'] ?>
                            <span class="text"> {{ $remark->remark }}</span>
                        <p>
                        @endforeach
                    @endif

                  </div>
                </div>

                @if(count($drink->pictures))
                <br>
                <h6 class="sub-category"> Drink Images </h6>
                <hr>
                <div class="center_txt">
                  <div class="images-display" id="drinkImagesDisplayOld">
                    @foreach($drink->pictures as $pic)
                    <div class="thumbnail">
                      <a href="{{ $pic->picture }}" class='js-smartphoto ' data-caption="{{ $pic->details }}" data-id="{{ $pic->id }}" data-group="{{ $drink->name}}">
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
