<?php
  $nav_bar_items = ['hotel'=>$hotel];
  $nav_bar_items += ['branch' => $branch];
  if(isset($department)) $nav_bar_items += ['department' => $department];
  $scope = (isset($department))? 'department':'branch';
 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection
