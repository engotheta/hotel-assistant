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
    <form method="POST"  action="{{url($functions->getLink('departments',$department,$branch,null))}}" enctype="multipart/form-data">
        @csrf

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit the {{ $department->name }} department  </span>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="departmentName"> Name </span>
                  </div>
                  <input  type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                  <input  type="text" name="name" class="form-control" value="{{ $department->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>


              @isset($members)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                    </div>
                    <select name="contact_person_id" class="custom-select" id="departmentContactPersonId">
                      <option value="" selected> None </option>
                      @foreach($members as $member)
                      <?php  $selected =  $member->id == $department->contact_person_id?  'selected':'';  ?>
                      <option value="{{$member->id}}" {{ $selected }}> {{$member->name}} </option>
                      @endforeach
                    </select>
                </div>
              @endisset

              <h4 class="section-title"> Services Offered </h4>
              <hr class="dividing-line">

              <div class="row fit-child">
                  @foreach($services as $service)
                  <?php
                    $checked = '';
                    foreach($department->services as $type){
                      if($service->id == $type->id ) { $checked = 'checked'; break; }
                    }
                  ?>
                  <div class="input-group mb-3 col-sm-6">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input {{$checked}} name="service_{{$service->id}}" value="{{$service->id}}" type="checkbox" aria-label="Checkbox for following text input">
                      </div>
                    </div>
                    <span class="form-control" aria-label="Text input with checkbox"> {{$service->name}}</span>
                  </div>
                  @endforeach
              </div>

              <h4 class="section-title"> Transaction Types for the Services </h4>
              <hr class="dividing-line">

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">department's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="departmentImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#departmentImagesDisplayEdit"
                   data-event="onchange"  multiple>
                </div>
              </div>
              <div class="center_txt">
                <div class="images-display" id="departmentImagesDisplayEdit"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="departmentImagesDisplayOld">
                    @foreach($department->pictures as $pic)
                    <div class="thumbnail">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </div>
                    @endforeach
                </div>
              </div>

              <div class="input-group field">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Department Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea">{{ $department->details }}</textarea>
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
