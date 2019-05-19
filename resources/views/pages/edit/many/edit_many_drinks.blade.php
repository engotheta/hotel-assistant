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
      <span class='system-text text'>Mass Edit the drinks in stock  </span>
    </div>

    <div class="card-body">
      @include('partials.messages')
      <?php
        $department = isset($department)? $department:null;
        $branch = isset($branch)? $branch:null;
       ?>

      <h4 class="section-title modal-header"> Drinks </h4>
      <form method="POST" name="drinks" action="{{$functions->getLink('drinks',null,$branch,$department).'/update-many'}}" enctype="multipart/form-data">
        @csrf
        <ul class="list-group list-group-flush field-group-list fit-child fit-parent">
            <li class="field-fit-child field-group edit-drinks-field-group fit-parent">
              <div class="name-field center-text"> # Name</div>
              <div class="stock-field center-text"> Stock</div>
              <div class="price-field center-text"> Price</div>
            </li>
            <?php   $n=0; ?>
            @forelse($drinks as $drink)
              <?php $n++; ?>
                <li class="list-group-item field-group-item fit-child fit-parent">
                  <div class="input-group field-group edit-drinks-field-group field mb-3 input-group-sm">

                      <div class="name-field  input-group-sm input-group-prepend ">
                         <button class="  btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <small> {{$n}} </small>
                         </button>
                         <div class="dropdown-menu">
                           <a class="dropdown-item toggle-editable" data-inputs="drinkField{{$n}}">
                             Toggle Edit
                           </a>
                           <a class="dropdown-item" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                             Toggle Extras
                           </a>

                         </div>
                         <input readonly type="text" name="name[]"  class="form-control no-radius drinkField{{$n}} drink-name" value="{{ $drink->name }}" aria-label="branchname" aria-describedby="basic-addon1">
                       </div>
                      <input required hidden type="number" name="id[]" value="{{$drink->id}}">
                      <input  type="text" name="stock[]" class="form-control stock-field  drink-name" value="{{ $drink->stock }}" aria-label="branchname" aria-describedby="basic-addon1">
                      <input required type="text" name="price[]" class="form-control price-field  drink-name" value="{{ $drink->price }}" aria-label="branchname" aria-describedby="basic-addon1">

                  </div>
                  <div id="collapseDetail{{$n}}" class="collapse">
                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01"> Drink type </label>
                          </div>
                          <select required name="drink_type_id[]" class="custom-select" id="drinkTypeId">
                            <option value="" selected> None </option>

                            @foreach($drink_types as $drink_type)
                              <?php
                                 $selected = ($drink_type->id == $drink->drink_type_id) ?  'selected':'';
                              ?>
                              <option value="{{$drink_type->id}}" {{$selected}}> {{$drink_type->name}} </option>
                            @endforeach

                          </select>
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01"> Drink Crate size </label>
                          </div>
                          <select name="crate_size_id[]" class="custom-select" id="drinkCrateSizeId">
                            <option value="" selected> None </option>

                            @foreach($crate_sizes as $crate_size)
                              <?php
                                 $selected = ($crate_size->id == $drink->crate_size_id) ?  'selected':'';
                              ?>
                              <option value="{{$crate_size->id}}" {{$selected}}> {{$crate_size->size}} </option>
                            @endforeach

                          </select>
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text system-text" id="drinkCratePrice">Crate Price </span>
                          </div>
                          <input type="number" name="crate_price[]" value="{{$drink->crate_price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                              <span class="input-group-text system-text" id="drinkCratePrice">Single drink buying Price </span>
                          </div>
                          <input type="number" name="single_price[]" value="{{$drink->single_price}}" class="form-control"  aria-label="drinksingleprice" aria-describedby="basic-addon1">
                      </div>

                      <div class="input-group input-group-sm field mb-3">
                          <div class="input-group-prepend">
                            <span class="input-group-text"> Drink Details </span>
                          </div>
                          <textarea name="details[]" class="form-control" aria-label="With textarea">{{$drink->details}}</textarea>
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

                      <h5 class="center-text">
                          <a href="{{$functions->getLink('drinks',$drink,$branch,$department).'/edit'}}" > Add Pictures </a>
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
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}/button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>
        </form>
    </div>


  </div>
@endsection
