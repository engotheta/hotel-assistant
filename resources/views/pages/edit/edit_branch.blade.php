<?php

    $department = isset($department)? $department:null;
    $branch = isset($branch)? $branch:null;

 ?>


@extends('layouts.home')

@section('nav_bar')
    @nav_bar([
        'hotel'=>$hotel,
    ])
    @endnav_bar

@endsection

@section('page')
<div class="card">
    <form method="POST"  action="{{url($functions->getLink('branches',$branch,null,null))}}" enctype="multipart/form-data">
        @csrf
        {{method_field('PUT')}}

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit the {{ $branch->name }} branch  </span>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="branchName"> Name </span>
                  </div>
                  <input required type="text" name="name" class="form-control" value="{{ $branch->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="branchAddressId"> Branch Address  </span>
                  </div>
                  <?php $add = ($branch->address) ? $branch->address->name:'' ?>
                  <input type="text" name="address" value="{{ $add }}" class="form-control"  aria-label="floor" aria-describedby="basic-addon1" required>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="branchFloor"> Max of Floors  </span>
                  </div>
                  <input required type="number" min="0" value="{{ $branch->floors }}" name="floors" class="form-control"  aria-label="floor" aria-describedby="basic-addon1">
              </div>

              @isset($members)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                    </div>
                    <select name="contact_person_id" class="custom-select" id="branchContactPersonId">
                      <option value="" selected> None </option>
                      @foreach($members as $member)
                      <?php $selected =  $member->id == $branch->contact_person_id?  'selected':''; ?>
                      <option value="{{$member->id}}" {{ $selected }}> {{$member->name}} </option>
                      @endforeach
                    </select>
                </div>
              @endisset

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Branch's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="branchimages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#branchesImagesDisplayEdit"
                   data-event="onchange"  multiple>
                </div>
              </div>
              <div class="center_txt">
                <div class="images-display" id="branchesImagesDisplayEdit"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="branchesImagesDisplayOld">
                    @foreach($branch->pictures as $pic)
                    <div class="thumbnail">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </div>
                    @endforeach
                </div>
              </div>

              <div class="input-group field">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> Branch Details </span>
                  </div>
                  <textarea name="details" class="form-control" aria-label="With textarea">{{ $branch->details }}</textarea>
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
