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
    <form method="POST"  action="{{$functions->getLink('activities',$activity,$branch,$department)}}" enctype="multipart/form-data">
      @csrf
      {{method_field('DELETE')}}

      <div class="card-header system-text">
        <i class="icon ti ti-trash"> </i>
        <span class='system-text text'> Delete {{ $activity->name }} from the branch </span>
      </div>

      <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="activityName"> Name </span>
                  </div>
                  <input readonly type="text" name="name" class="form-control" value="{{ $activity->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="activityName"> Price </span>
                  </div>
                  <input readonly required type="number" name="price" value="{{$activity->price}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              @if($activity->contact_person_id)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                    </div>
                    <select readonly name="contact_person_id" class="form-control" id="departmentContactPersonId">
                      <option value="" selected> None </option>
                      @foreach($members as $member)
                      <?php  $selected =  $member->id == $activity->contact_person_id?  'selected':'';  ?>
                      <option value="{{$member->id}}" {{$selected}}> {{$member->name}} </option>
                      @endforeach
                    </select>
                </div>
              @endif

              @if($activity->details)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> Activity Details </span>
                    </div>
                    <textarea readonly name="details" class="form-control" aria-label="With textarea">{{$activity->details}}</textarea>
                </div>
              @endif

              @if(count($activity->pictures))
              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Activity's Pictures</label>
                </div>
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
              @endif

        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{ $functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input  class="btn btn-primary" type="submit"  value="Delete this Activity">
        </div>

  </form>
</div>
@endsection
