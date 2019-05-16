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
    $nav_bar_items += ['model' => 'drinks-variables'];

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
      <i class="icon ti ti-pencil"> </i>
      <span class='system-text text'>Edit  the Drinks Variables  </span>
    </div>

    <div class="card-body">

        @include('partials.messages')

        <h4 class="section-title"> Drink Types</h4>
        <form method="POST" name="drink_types" action="{{$functions->getLink('drink-types',null,$branch,$department).'/update-many'}}" enctype="multipart/form-data">
          @csrf
          <ul class="list-group list-group-flush ">
              <?php   $n=0; ?>
              @forelse($drink_types as $drink_type)
                <?php $n++; ?>
                  <li class="list-group-item ">
                    <div class="input-group field mb-3">
                        <div class="input-group-prepend">
                           <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {{$n}}
                           </button>
                           <div class="dropdown-menu">
                             <a class="dropdown-item toggle-editable" data-inputs="drinkTypeField{{$n}}">Edit</a>
                             <a class="dropdown-item" href="{{$functions->getIdLink('drink-types',$drink_type->id,$branch,$department).'/destroy'}}">Delete</a>
                           </div>
                         </div>
                        <input hidden type="number" name="id[]" value="{{$drink_type->id}}">
                        <input readonly type="text" name="name[]" id="drinkTypeName{{$n}}" class="form-control drinkTypeField{{$n}} drink-type-name" value="{{ $drink_type->name }}" aria-label="branchname" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <span class="input-group-text btn system-text" id="drinkName" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                              details
                            </span>
                        </div>
                    </div>
                    <div id="collapseDetail{{$n}}" class="collapse">
                      <textarea readonly name="details[]" id="drinkTypeDetails{{$n}}" class=" form-control drinkTypeField{{$n}} drink-type-details" aria-label="With textarea">{{$drink_type->details}}</textarea>
                    </div>
                  </li>
              @empty
              @endforelse
            </ul>
            <hr class="dividing-line transparent">
            <div class="input-group field center-text flex-container flex-between">
              <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#addNewDrinkType" aria-expanded="false" aria-controls="collapseNewDrinkTYpe" >
                Add New Type!
              </button>
              <input class="btn btn-primary" type="submit"  value="Save Types Changes">
            </div>
          </form>
      </div>

      <div class="card-footer collapse"  id="addNewDrinkType" >
        <h4 class="section-title system-text"> Add a new Drink Type</h4>
        <form method="POST" action="{{$functions->getLink('drink-types',null,$branch,$department)}}" enctype="multipart/form-data">
          @csrf
              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="drinkName"> Name </span>
                  </div>
                  <input  type="text" name="name" class="form-control" placeholder="drink type name" aria-label="branchname" aria-describedby="basic-addon1">
              </div>
              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Drink type Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
              </div>
              <hr class="dividing-line">
              <div class="input-group field center-text flex-container flex-between">
                <input class="btn btn-primary" type="submit"  value="Save The New Drink Type">
              </div>
      </form>
    </div>

    <div class="card-body">
        <h4 class="section-title"> Crate sizes </h4>
        <form method="POST" name="crate_sizes" action="{{$functions->getLink('crate-sizes',null,$branch,$department).'/update-many'}}" enctype="multipart/form-data">
          @csrf

          <ul class="list-group list-group-flush">
              <?php   $n=0; ?>
              @forelse($crate_sizes as $crate_size)
                <?php $n++; ?>
                  <li class="list-group-item">
                    <div class="input-group field mb-3">
                        <div class="input-group-prepend">
                           <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             {{$n}}
                           </button>
                           <div class="dropdown-menu">
                             <a class="dropdown-item toggle-editable" data-inputs="crateSizeField{{$n}}">Edit</a>
                             <a class="dropdown-item" href="{{$functions->getIdLink('crate-sizes',$crate_size->id,$branch,$department).'/destroy'}}">Delete</a>
                           </div>
                         </div>
                        <input hidden type="number" name="id[]" value="{{$crate_size->id}}">
                        <input readonly type="number" name="size[]" id="CrateSize{{$n}}" class="form-control crateSizeField{{$n}} drink-type-name" value="{{ $crate_size->size }}" aria-label="branchname" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <span class="input-group-text btn system-text" id="drinkName" data-toggle="collapse" data-target="#collapseDetail{{$n}}" aria-expanded="false" aria-controls="collapseExample">
                              details
                            </span>
                        </div>
                    </div>
                    <div id="collapseDetail{{$n}}" class="collapse">
                      <textarea readonly name="details[]" id="crateSizeDetails{{$n}}" class=" form-control crateSizeField{{$n}} crate-size-details" aria-label="With textarea">{{$crate_size->details}}</textarea>
                    </div>
                  </li>
              @empty
              @endforelse
            </ul>
            <hr class="dividing-line transparent">
            <div class="input-group field center-text flex-container flex-between">
              <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#addNewCrateSize" aria-expanded="false" aria-controls="collapseNewCrateSize" >
                Add New Size!
              </button>
              <input class="btn btn-primary" type="submit"  value="Save Sizes Changes">
            </div>

          </form>
    </div>


    <div class="card-footer collapse"  id="addNewCrateSize" >
      <h4 class="section-title system-text"> Add a new Crate Size</h4>
      <form method="POST" action="{{$functions->getLink('crate-sizes',null,$branch,$department)}}" enctype="multipart/form-data">
        @csrf
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="crateSize"> size </span>
                </div>
                <input  type="number" name="size" class="form-control" placeholder="crate size" aria-label="crateSize" aria-describedby="basic-addon1">
            </div>
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Crate Size Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>
            <hr class="dividing-line">
            <div class="input-group field center-text flex-container flex-between">
              <input class="btn btn-primary" type="submit"  value="Save The New Crate size">
            </div>
      </form>
    </div>

    <div class="card-footer">

      <div class="input-group field center-text flex-container flex-between">
        <a href="{{$functions->getReturnLink($branch,$department)}}" >
          <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
        </a>
      </div>
    </div>

  </div>
@endsection
