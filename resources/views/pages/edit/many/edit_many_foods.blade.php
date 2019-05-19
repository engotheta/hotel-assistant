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
      <span class='system-text text'>Mass Edit the foods in stock  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')
      <?php
        $department = isset($department)? $department:null;
        $branch = isset($branch)? $branch:null;
       ?>

      <h4 class="section-title modal-header"> Foods </h4>
      <form method="POST" name="foods" action="{{$functions->getLink('foods',null,$branch,$department).'/update-many'}}" enctype="multipart/form-data">
        @csrf
        <ul class="list-group list-group-flush field-group-list fit-child fit-parent">
            <li class="field-fit-child field-group edit-foods-field-group fit-parent">
              <div class="name-field center-text"> # Name </div>
              <div class="stock-field center-text"> Stock </div>
              <div class="price-field center-text"> Price </div>
            <?php   $n=0; ?>
            @forelse($foods as $food)
              <?php $n++; ?>
                <li class="list-group-item field-group-item fit-child fit-parent">
                  <div class="input-group field-group edit-foods-field-group field mb-3 input-group-sm">

                      <div class="name-field  input-group-sm input-group-prepend ">
                         <button class="  btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <small> {{$n}} </small>
                         </button>
                         <div class="dropdown-menu">
                           <a class="dropdown-item toggle-editable" data-inputs="foodField{{$n}}">
                             Toggle Edit
                           </a>
                           <a class="dropdown-item" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                             Toggle Extras
                           </a>

                         </div>
                         <input readonly type="text" name="name[]"  class="form-control no-radius foodField{{$n}} food-name" value="{{ $food->name }}" aria-label="branchname" aria-describedby="basic-addon1">
                       </div>
                      <input required hidden type="number" name="id[]" value="{{$food->id}}">
                      <input  type="number" name="stock[]" class="form-control stock-field  food-name" value="{{ $food->stock }}" aria-label="branchname" aria-describedby="basic-addon1">
                      <input required type="number" name="price[]" class="form-control price-field  food-name" value="{{ $food->price }}" aria-label="branchname" aria-describedby="basic-addon1">

                  </div>
                  <div id="collapseDetail{{$n}}" class="collapse">

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"> Food Details </span>
                          </div>
                          <textarea name="details[]" class="form-control" aria-label="With textarea">{{$food->details}}</textarea>
                      </div>

                      <div class="center_txt">
                        <div class="images-display" id="foodImagesDisplayOld">

                          @foreach($food->pictures as $pic)
                          <div class="thumbnail">
                            <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                          </div>
                          @endforeach

                        </div>
                      </div>

                      <h5 class="center-text">
                          <a href="{{$functions->getLink('foods',$food,$branch,$department).'/edit'}}" > Add Pictures </a>
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
