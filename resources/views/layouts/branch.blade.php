@extends('layouts.with_panes')

@section('content')
  @yield('page')
  @include('partials.modals.hotel_name_modal')
  @include('partials.modals.delete_departments_modal')
  @include('partials.modals.edit_departments_modal')
  @include('partials.modals.edit_members_modal')
  @include('partials.modals.delete_members_modal')
  @include('partials.modals.edit_activities_modal')
  @include('partials.modals.delete_activities_modal')
  @include('partials.modals.edit_venues_modal')
  @include('partials.modals.delete_venues_modal')
  @include('partials.modals.edit_rooms_modal')
  @include('partials.modals.delete_rooms_modal')
  @include('partials.modals.edit_drinks_modal')
  @include('partials.modals.delete_drinks_modal')
  @include('partials.modals.edit_foods_modal')
  @include('partials.modals.delete_foods_modal')

@endsection

@section('admin_panel')
    @admin_panel([
      'themify_icons' => $themify_icons,
      'members' => $members,
      'items' => [

          [
            'name' => 'departments',
            'actions' => [['name'=>'add','link'=>'/departments/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
            'target'=>'DepartmentsModal' ],
          [
            'name' => 'members',
            'actions' => [['name'=>'add','link'=>'/users/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'titles','link'=>'/titles/'.$branch->slug]] ,
            'target'=>'MembersModal' ],
          [
            'name' => 'activities',
            'actions' => [['name'=>'add','link'=>'/activities/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
            'target'=>'ActivitiesModal' ],
          [
            'name' => 'venues',
            'actions' => [['name'=>'add','link'=>'/venues/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
            'target'=>'VenuesModal' ],
          [
            'name' => 'rooms',
            'actions' => [['name'=>'add','link'=>'/rooms/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'variables','link'=>'/rooms-variables/'.$branch->slug]] ,
            'target'=>'RoomsModal' ],
          [
            'name' => 'drinks',
            'actions' => [['name'=>'add','link'=>'/drinks/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete'],['name'=>'variables','link'=>'/drinks-variables/'.$branch->slug]] ,
            'target'=>'DrinksModal' ],
          [
            'name' => 'foods',
            'actions' => [['name'=>'add','link'=>'/foods/'.$branch->slug.'/create'],['name'=>'edit'],['name'=>'delete']] ,
            'target'=>'FoodsModal' ],
      ],
    ])
    @endadmin_panel
@endsection

@section('view_panel')
    @view_panel([
      'themify_icons' => $themify_icons,
      'items' => [
          [
            'name' => 'business days',
            'link' => '/businessdays/'.$branch->slug,
            'instance' => $businessdays, ],
          [
            'name' => 'unpaid loans',
            'link' => '/unpaid-loans/.$branch->slug',
            'instance' => $unpaid_loans, ],
          [
            'name' => 'venue bookings',
            'link' => '/venue-bookings/'.$branch->slug,
            'instance' => $venue_bookings, ],
          [
            'name' => 'members',
            'link' => '/members/'.$branch->slug,
            'instance' => $members, ],
          [
            'name' => 'rooms',
            'link' => '/rooms/'.$branch->slug,
            'instance' => $rooms, ],
          [
            'name' => 'drinks',
            'link' => '/drinks/'.$branch->slug,
            'instance' => $drinks, ],
          [
            'name' => 'foods',
            'link' => '/foods/'.$branch->slug,
            'instance' => $foods, ],
          [
            'name' => 'venues',
            'link' => '/venues/'.$branch->slug,
            'instance' => $venues, ],
          [
            'name' => 'activities',
            'link' => '/activities/'.$branch->slug,
            'instance' => $activities, ],
      ]

    ])
    @endview_panel
@endsection
