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
      <i class="icon ti ti-pencil"> </i>
      <span class='system-text text'>Mass Edit the available foods </span>
    </div>

    <div class="card-body">
      @include('partials.messages')
      <?php
        $department = isset($department)? $department:null;
        $branch = isset($branch)? $branch:null;
       ?>

      <h4 class="section-title modal-header"> Drinks </h4>
      <form method="POST" name="foods" action="{{$functions->getLink('foods',null,$branch,$department).'/store-many'}}" enctype="multipart/form-data">
        @csrf
        <ul class="list-group list-group-flush field-group-list fit-child fit-parent">
            <li class="field-fit-child add-foods-field-group fit-parent">
              <div class="name-field center-text"> # Name </div>
              <div class="stock-field center-text"> Stock </div>
              <div class="price-field center-text"> Price </div>
            </li>

            <li class="list-group-item field-group-item  food-field fit-child fit-parent" id="createField_1">
              <div class="input-group field-group add-foods-field-group field mb-3 input-group-sm">

                  <div class="name-field  input-group-sm input-group-prepend ">
                     <button class="  btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <small class="index"> 1 </small>
                     </button>
                     <div class="dropdown-menu">

                       <a class="dropdown-item collapse-detail" data-toggle="collapse" data-target="#collapseDetail_1" aria-expanded="false" aria-controls="collapseExample">
                         Toggle Optionals
                       </a>
                       <a class="dropdown-item remove-field" data-field="#createField_1" >
                         Remove this Item
                       </a>

                     </div>
                     <input required type="text" name="name[]"  class="form-control no-radius food-field_1 input food-name" placeholder="name" aria-label="branchname" aria-describedby="basic-addon1">
                   </div>

                   <input  type="text" name="stock[]" class="form-control stock-field  input"  placeholder="stock" aria-label="branchname" aria-describedby="basic-addon1">
                   <input required  type="text" name="price[]" class="form-control price-field  input"  placeholder="price" aria-label="branchname" aria-describedby="basic-addon1">

              </div>
              <div id="collapseDetail_1" class="collapse">

                  <div class="input-group input-group-sm field mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"> Food Details </span>
                      </div>
                      <textarea name="details[]" class="form-control input" aria-label="With textarea"></textarea>
                  </div>

              </div>
            </li>

          </ul>
          <div class="add-field clone-field center-text" data-field="#createField_1" data-type="add-food" data-update="yes" data-model="food">
            <i class="icon ti ti-plus"> </i>
          </div>

          <hr class="dividing-line transparent">
          <div class="input-group field center-text flex-container flex-between">
            <a href="{{$functions->getReturnLink($branch,$department)}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Add foods">
          </div>
        </form>
    </div>


  </div>
@endsection
