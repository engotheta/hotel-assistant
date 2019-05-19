@extends('layouts.with_panes')

<?php
  $roomz=true;$drinkz=true;$venuez=true;$foodz=true;

  if(isset($department)){
    $is_department = $department;
    $roomz=false;$drinkz=false;$venuez=false;$foodz=false;
    foreach($department->services as $service ){
        switch($service->name){
          case 'rooms' : $roomz=true; break;
          case 'drinks' : $drinkz=true; break;
          case 'venues' : $venuez=true; break;
          case 'foods' :$foodz=true; break;
        }
    }
  }
?>

@section('content')
  @yield('page')
  @include('partials.modals.hotel_name_modal')
  @include('partials.modals.branches_modal')
  @include('partials.modals.departments_modal')
  @include('partials.modals.members_modal')
  @include('partials.modals.activities_modal')

  @includeWhen($venuez,'partials.modals.venues_modal')
  @includeWhen($roomz,'partials.modals.rooms_modal')
  @includeWhen($drinkz,'partials.modals.drinks_modal')
  @includeWhen($foodz,'partials.modals.foods_modal')
@endsection


@section('admin_panel')
    @admin_panel([
      'themify_icons' => $themify_icons,
      'items' => $admin_items,
    ])
    @endadmin_panel
@endsection

@section('view_panel')
    @view_panel([
      'themify_icons' => $themify_icons,
      'items' => $view_items,
    ])
    @endview_panel
@endsection
