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
  <form method="POST"  action="{{$functions->getLink('departments',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
      <span class="text"> {{$branch->name}} </span>
    </div>

    <div class="card-body">

          @include('partials.messages')

          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">
              Add a new Department to {{ $branch->name}}'s branch
            </h5>
          </div>

          <div class="modal-body">

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="departmentName"> Name </span>
                  </div>
                  <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                  <input required type="text" name="name" class="form-control" placeholder="Department Name" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              @isset($members)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                    </div>
                    <select name="contact_person_id" class="custom-select" id="departmentContactPersonId">
                      <option value="" selected> None </option>
                      @foreach($members as $member)
                      <option value="{{$member->id}}"> {{$member->name}} </option>
                      @endforeach
                    </select>
                </div>
              @endisset

              <h5 class="section-title stystem-text"> Possible Services offered in the department </h5>
              <small class=""> check only the ones avialable for transations in the department</small>
              <hr class="dividing-line">

              <div class="row fit-child">
                @foreach($services as $service)
                  <div class="input-group mb-3 col-sm-6">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input name="service_{{$service->id}}" value="{{$service->id}}" type="checkbox" aria-label="Checkbox for following text input">
                      </div>
                    </div>
                    <span class="form-control" aria-label="Text input with checkbox"> {{$service->name}}</span>
                  </div>
                @endforeach
              </div>


              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">


              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Department's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="departmentImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#departmentImagesDisplay"
                   data-event="onchange"  multiple>
                </div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="departmentImagesDisplay"></div>
              </div>

              <div class="input-group field">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Department Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
              </div>

          </div>
      </div>

      <div class="card-footer input-group field center-text flex-container flex-between">
        <a href="{{ $functions->getReturnLink($branch,$department)}}" >
          <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
        </a>
        <input class="btn btn-primary" type="submit"  value="Add The Department">
      </div>

  </form>
</div>
@endsection
