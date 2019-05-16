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
    $activity = isset($activity)? $activity:null;

 ?>


@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection


@section('page')
<div class="card">
  <form method="POST"  action="{{url($functions->getLink('activities',$activity,$branch,$department))}}" enctype="multipart/form-data">
      @csrf
      {{method_field('PUT')}}

      <div class="card-header system-text">
        <i class="icon ti ti-pencil"> </i>
        <span class='system-text text'>Edit  {{ $activity->name }}'s information  </span>
      </div>

      <div class="card-body">

            @include('partials.messages')

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="activityName"> Name </span>
                </div>
                <input  type="text" name="name" class="form-control" value="{{ $activity->name }}" aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="activityName"> Price </span>
                </div>
                <input required type="number" name="price" value="{{$activity->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            <div class="row fit-child">
              @foreach($transaction_types as $transaction_type)
                  <?php
                    $checked = '';
                    foreach($activity->transactionTypes as $type){
                      if($transaction_type->id == $type->id ) { $checked = 'checked'; break; }
                    }
                  ?>

                <div class="input-group mb-3 col-sm-6">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <input {{$checked}} name="transaction_type_{{$transaction_type->id}}" value="{{$transaction_type->id}}" type="checkbox" aria-label="Checkbox for following text input">
                    </div>
                  </div>
                  <span class="form-control" aria-label="Text input with checkbox"> {{$transaction_type->name}}</span>
                </div>
              @endforeach
            </div>

            <h4 class="section-title"> Optional Fields </h4>
            <hr class="dividing-line">

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                </div>
                <select name="contact_person_id" class="custom-select" id="departmentContactPersonId">
                  <option value="" selected> None </option>
                  @foreach($members as $member)
                  <?php   $selected =  $member->id == $activity->contact_person_id?  'selected':'';   ?>
                  <option value="{{$member->id}}" {{$selected}}> {{$member->name}} </option>
                  @endforeach
                </select>
            </div>

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Activity Details </span>
                </div>
                <textarea name="details" class="form-control" aria-label="With textarea">{{$activity->details}}</textarea>
            </div>

            <div class="input-group field mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" for="images">Activity's Pictures</label>
              </div>
              <div class="custom-file">
                <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                 data-multiple-caption="{count} files selected" data-display="#activityImagesDisplay"
                 data-event="onchange"  multiple>
              </div>
            </div>

            <div class="center_txt">
              <div class="images-display" id="activityImagesDisplay"></div>
            </div>

            <div class="center_txt">
              <div class="images-display" id="activityImagesDisplayOld">
                  @foreach($activity->pictures as $pic)
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
