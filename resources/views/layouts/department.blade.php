@extends('layouts.with_panes')

@section('content')
  @yield('page')
  @include('partials.modals.hotel_name_modal')

<?php
  $roomz=false;$drinkz=false;$venuez=false;$foodz=false;
  foreach($department->services as $service ){
      switch($service->name){
        case 'rooms' : $roomz=true; break;
        case 'drinks' : $drinkz=true; break;
        case 'venues' : $venuez=true; break;
        case 'foods' :$foodz=true; break;
      }
  }
  ?>

  @includeWhen($venuez,'partials.modals.edit_venues_modal')
  @includeWhen($venuez,'partials.modals.delete_venues_modal')
  @includeWhen($roomz,'partials.modals.edit_rooms_modal')
  @includeWhen($roomz,'partials.modals.delete_rooms_modal')
  @includeWhen($drinkz,'partials.modals.edit_drinks_modal')
  @includeWhen($drinkz,'partials.modals.delete_drinks_modal')
  @includeWhen($foodz,'partials.modals.edit_foods_modal')
  @includeWhen($foodz,'partials.modals.delete_foods_modal')

@endsection

@section('admin_panel')
    @admin_panel([
      'themify_icons' => $themify_icons,
      'members' => $members,
      'services' => $services,
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
