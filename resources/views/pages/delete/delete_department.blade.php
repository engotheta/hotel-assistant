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
  <form method="POST"  action="{{$functions->getLink('departments',$department,$branch,null)}}" enctype="multipart/form-data">
    @csrf
    {{method_field('DELETE')}}

    <div class="card-header system-text">
      <i class="icon ti ti-trash"> </i>
      <span class='system-text text'> Delete the {{ $department->name }} branch </span>
    </div>

    <div class="card-body">

            @include('partials.messages')

            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="branchName"> Name </span>
                </div>
                <input readonly required type="text" name="name" class="form-control" value="{{ $department->name }}" aria-label="branchname" aria-describedby="basic-addon1">
            </div>

            @isset($members)
            <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="inputGroupSelect01">Department Contact Member </label>
                </div>
                @foreach($members as $member)
                <?php $selected = ( $member->id == $department->contact_person_id )?  $member->name:''; ?>
                @endforeach
                <input readonly type="text" name="contact_person_id" value="<?php if(isset($selected)) echo $selected ?>" class="form-control"  aria-label="floor" aria-describedby="basic-addon1" required>
            </div>
            @endisset

            <div class="input-group field">
                <div class="input-group-prepend">
                  <span class="input-group-text"> Department Details </span>
                </div>
                <textarea readonly name="details" class="form-control" aria-label="With textarea">{{ $department->details }}</textarea>
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

        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Delete this Branch">
        </div>

    </form>
  </div>
@endsection
