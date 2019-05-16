<?php

    $nav_bar_items = ['hotel'=>$hotel];

    if(isset($department)){
      $scope = 'department';
      $is_department = $department;
    }elseif(isset($activity)){
      $scope = 'outsider';
      $services = (object)json_decode(json_encode([['name'=>$activity->name],]));
      $is_department = $activity;
      $transaction_types = $transaction_types;
    }elseif(isset($branch)){
      $scope = 'branch';
    }else{
      $scope = 'home';
    }

    if(isset($branch)) $nav_bar_items += ['branch' => $branch];
    if(isset($department)) $nav_bar_items += ['department' => $department];
    if(isset($activity)) $nav_bar_items += ['activity' => $activity];

    $department = isset($department)? $department:null;
    $activity = isset($activity)? $activity:null;
    $branch = isset($branch)? $branch:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">
  <form method="POST"  action="{{$functions->getLink('businessdays',null,$branch,$is_department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$is_department->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">
               New Businessday
            </h5>
          </div>

          <div class="modal-body">

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="departmentName"> Businessday Name </span>
                  </div>
                  <input required type="number" value="{{$branch->id}}" name="branch_id" class="form-control none" hidden>
                  @if($department)
                  <input required type="number" value="{{$department->id}}" name="department_id" class="form-control none" hidden>
                  @endif
                  @if($activity)
                  <input required type="number" value="{{$activity->id}}" name="activity_id" class="form-control none" hidden>
                  @endif
                  <input required type="number" value="{{Auth::user()->id}}" name="user_id" class="form-control none" hidden>
                  <input required type="text" name="name" class="form-control" placeholder="YYY-MM-DD">
              </div>

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <input checked name="weekend_or_holiday" type="checkbox" aria-label="Checkbox for following text input">
                  </div>
                </div>
                <span class="form-control" aria-label="Text input with checkbox"> Weekend or Holiday?</span>
              </div>

              <h5 class="section-title stystem-text">  Transactions </h5>
              <hr class="dividing-line">

              @forelse($services as $service)
              <?php
                  $sname = str_replace(" ","",trim($service->name));
                  if($activity) $service = $activity;
                  $transaction_types = $service->transactionTypes;
              ?>
              <div id="{{$sname.'Businessday'}}">
                <div class="businessday-header flex-container flex-between">
                  <span class="wide primary top-round dropdown-toggle"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                      >
                      {{$sname}}
                   </span>
                    <div class="dropdown-menu">
                      <a class="dropdown-item">
                        Save State
                      </a>
                    </div>
                    <span class="group-total top-round primary money wide"> 3000 </span>
                </div>

                <div id="{{$sname.'Transactions'}}">
                  <!-- transaction groups are place here -->
                </div>

                <div id="{{$sname.'BusinessdayFooter'}}" class="input-group center-text flex-container flex-between">
                  <button type="button" class="round primary-outline wide" data-toggle='modal' data-target="#{{$sname.'TransactionTypesModal'}}"> Add Transaction Type </button>
                  <span  class="round primary money wide" > 1000 </span>
                </div>

              </div>
              <div class="transactionTypes ">
                <div class="transaction-type-list row ">
                  @include('partials.modals.transaction_types_modal')
                  @foreach($transaction_types as $transaction_type)
                  <div class="transaction-type-list-item col-4">
                      <input id="{{$sname.'TransactionType_'.$transaction_type->id}}"
                      data-option="#{{$sname.'TransactionTypeOption_'.$transaction_type->id}}"
                      name="{{$sname.'_'.$transaction_type->name}}" value="{{$transaction_type->id}}"
                      class="option-checkbox" type="checkbox" >
                      <span > {{$transaction_type->name}}</span>
                  </div>
                  @endforeach
                </div>
              </div>

              @empty
              <div>
                  Go add some services in {{$is_department->name}} to record some transaction
              </div>
              @endforelse

              <div class="templates">
                  @include('partials.templates.transaction_group')
                  @include('partials.templates.single_sale_field')
              </div>

              @if(!$activity)
              <div id="checkList">
                  @include('partials.assets_checklist')
              </div>
              @endif

            <h4 class="section-title"> Optional Fields </h4>
            <hr class="dividing-line">

            <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="images">Businessday's Pictures</label>
              </div>
              <div class="custom-file">
                <input name="images[]" id="businessdayImages" type="file" class="thumbnail-creator custom-file-input"
                 data-multiple-caption="{count} files selected" data-display="#businessdayImagesDisplay"
                 data-event="onchange"  multiple>
              </div>
            </div>
            <div class="center_txt">
              <div class="images-display" id="businessdayImagesDisplay"></div>
            </div>

            <div class="input-group field">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Businessday Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
            </div>

        </div>
      </div>

      <div class="card-footer input-group field center-text flex-container flex-between">
        <a href="{{ $functions->getReturnLink($branch,$is_department)}}" >
          <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$is_department)}}</button>
        </a>
        <input class="btn btn-primary" type="submit"  value="Add The Department">
      </div>

    </form>
</div>
@endsection
