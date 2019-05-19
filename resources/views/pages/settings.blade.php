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
      <span class='system-text text'> General Settings  </span>
    </div>

    <div class="card-body">

      <form method="POST" name="set_hotel" action="{{url($functions->getLink('settings',null,null,null).'/save')}}">
        @csrf

          @foreach($settings as $setting)
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="basic-addon1">{{$setting->name}}</span>
                    <input type="text" name="name[]" value="{{$setting->name}}" class="form-control" hidden>
                </div>
                <input type="text" name="value[]" class="form-control" value="{{$setting->value}}" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          @endforeach

          <hr class="dividing-line">

          <div class="input-group field center-text flex-container flex-between">
            <a href="{{ url($functions->getReturnLink($branch,$department))}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>

      </form>
    </div>
  </div>

@endsection
