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
    <form method="POST"  action="{{url($functions->getLink('drinks',$drink,$branch,$department))}}" enctype="multipart/form-data">
        @csrf
        {{method_field('PUT')}}

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit Drink {{ $drink->name }}'s information  </span>
        </div>

        <div class="menu modal-header" id="editDepartment">
          <a class="menu-option" href="{{url($functions->getLink('drinks',null,$branch,$department).'/edit-many')}}">
            <i class="icon fi ti-wand "> </i>
            <span class="system-text"> Edit Many  </span>
          </a>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkName"> Name </span>
                  </div>
                  <input  type="text" name="name" class="form-control" value="{{ $drink->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Drink type </label>
                  </div>
                  <select name="drink_type_id" class="custom-select" id="drinkTypeId">
                    <option value="" selected> None </option>
                    @foreach($drink_types as $drink_type)
                    <?php $selected = ($drink_type->id == $drink->drink_type_id) ?  'selected':'';  ?>
                    <option value="{{$drink_type->id}}" {{$selected}}> {{$drink_type->name}} </option>
                    @endforeach
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkPrice">Price </span>
                  </div>
                  <input required type="number" name="price" value="{{$drink->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkStock">amout available in stock</span>
                  </div>
                  <input type="number" name="stock" class="form-control" value="{{$drink->stock}}" aria-label="price" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Drink Crate size </label>
                  </div>
                  <select name="crate_size_id" class="custom-select" id="drinkCrateSizeId">
                    <option value="" selected> None </option>
                    @foreach($crate_sizes as $crate_size)
                    <?php  $selected = ($crate_size->id == $drink->crate_size_id) ?  'selected':'';  ?>
                    <option value="{{$crate_size->id}}" {{$selected}}> {{$crate_size->size}} </option>
                    @endforeach
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkCratePrice">Crate Price </span>
                  </div>
                  <input type="number" name="crate_price" value="{{$drink->crate_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkCratePrice">Single drink buying Price </span>
                  </div>
                  <input type="number" name="single_price" value="{{$drink->single_price}}" class="form-control"  aria-label="drinksingleprice" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Drink Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea">{{$drink->details}}</textarea>
              </div>

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Drink's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#drinkImagesDisplay"
                   data-event="onchange"  multiple>
                </div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="drinkImagesDisplay"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="drinkImagesDisplayOld">
                  @foreach($drink->pictures as $pic)
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
