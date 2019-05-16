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
  <form method="POST"  action="{{$functions->getLink('foods',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf
    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="menu modal-header" id="editDepartment">
            <a class="menu-option" href="{{url($functions->getLink('foods',null,$branch,$department).'/add-many')}}">
              <i class="icon fi ti-wand "> </i>
              <span class="system-text"> Add Many  </span>
            </a>
          </div>

          <div class="modal-header">
            <h5 class="modal-title system-text " id="addfood">
              Add a new food to {{ $branch->name}}'s branch
            </h5>
          </div>

          <div class="modal-body">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="foodName"> Name </span>
                    </div>
                    <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                    <input required type="text" name="name" class="form-control" placeholder="food's name" aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="foodWeekdayPrice">food Price </span>
                    </div>
                    <input required type="number" name="price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>


                <h4 class="section-title"> Optional Fields </h4>
                <hr class="dividing-line">


                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="foodstock">amout available in stock</span>
                    </div>
                    <input  type="number" name="stock" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>


                <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="images">food's Pictures</label>
                  </div>
                  <div class="custom-file">
                    <input name="images[]" id="foodImages" type="file" class="thumbnail-creator custom-file-input"
                     data-multiple-caption="{count} files selected" data-display="#foodImagesDisplay"
                     data-event="onchange"  multiple>
                  </div>
                </div>
                <div class="center_txt">
                  <div class="images-display" id="foodImagesDisplay"></div>
                </div>

                <div class="input-group field">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> food Details </span>
                    </div>
                    <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
                </div>

            </div>
        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{ $functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Add The food">
        </div>

    </form>
</div>
@endsection
