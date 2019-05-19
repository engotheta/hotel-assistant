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
  <form method="POST"  action="{{$functions->getLink('drinks',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="menu modal-header" id="editDepartment">
            <a class="menu-option" href="{{url($functions->getLink('drinks',null,$branch,$department).'/add-many')}}">
              <i class="icon fi ti-wand "> </i>
              <span class="system-text"> Add Many  </span>
            </a>
          </div>

          <div class="modal-header">
            <h5 class="modal-title system-text " id="adddrink">
              Add a new drink to {{ $branch->name}}'s branch
            </h5>
          </div>

          <div class="modal-body">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="drinkName"> Name </span>
                    </div>
                    <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                    <input required type="text" name="name" class="form-control" placeholder="drink's name" aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="drinkWeekdayPrice">drink Price </span>
                    </div>
                    <input required type="number" name="price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="drinkType">drink Type </span>
                    </div>
                    <select required name="drink_type_id" class="form-control"  >
                       @foreach($drink_types as $drink_type)
                          <option value="{{$drink_type->id}}"> {{$drink_type->name}} </option>
                        @endforeach
                    </select>
                </div>

                <h4 class="section-title"> Optional Fields </h4>
                <hr class="dividing-line">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="drinkStock">amout available in stock</span>
                    </div>
                    <input  type="number" name="stock" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="CrateSize">Crate Size </span>
                    </div>
                    <select required name="$crate_size_id" class="form-control"  >
                       @foreach($crate_sizes as $crate_size)
                          <option value="{{$crate_size->id}}">{{ $crate_size->size}} </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="singleDrinkPrice">single drink Buying Price </span>
                    </div>
                    <input  type="number" name="single_price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="drinkCratePrice">Crate Price </span>
                    </div>
                    <input  type="number" name="crate_price" class="form-control"  aria-label="price" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="images">drink's Pictures</label>
                  </div>
                  <div class="custom-file">
                    <input name="images[]" id="drinkImages" type="file" class="thumbnail-creator custom-file-input"
                     data-multiple-caption="{count} files selected" data-display="#drinkImagesDisplay"
                     data-event="onchange"  multiple>
                  </div>
                </div>
                <div class="center_txt">
                  <div class="images-display" id="drinkImagesDisplay"></div>
                </div>

                <div class="input-group field">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> drink Details </span>
                    </div>
                    <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
                </div>

            </div>
        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Add The drink">
        </div>

    </form>
</div>
@endsection
