@extends('layouts.with_panes')

@section('content')
  @yield('page')
  @include('partials.modals.hotel_name_modal')
  @include('partials.modals.edit_branches_modal')
  @include('partials.modals.delete_branches_modal')
  @include('partials.modals.add_branch_modal')
@endsection

@section('admin_panel')
    @admin_panel([
      'themify_icons' => $themify_icons,
      'members' => $members,
      'items' => [
          [
            'name' => 'settings' ,
            'actions'=> [['name'=>'edit','link'=>'settings'],],
            'target'=>'SettingsModal' ],
          [
            'name' => 'branches',
            'actions' => [
                    ['name'=>'add', 'link'=>'/branches/create'],
                    ['name'=>'edit'],
                    ['name'=>'delete']
                  ] ,
            'target'=>'BranchModal' ],
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
            'link' => 'businessdays',
            'instance' => $businessdays, ],
          [
            'name' => 'unpaid loans',
            'link' => 'unpaid-loans',
            'instance' => $unpaid_loans, ],
          [
            'name' => 'venue bookings',
            'link' => 'venue-bookings',
            'instance' => $venue_bookings, ],
          [
            'name' => 'members',
            'link' => 'members',
            'instance' => $members, ],
          [
            'name' => 'rooms',
            'link' => 'rooms',
            'instance' => $rooms, ],
          [
            'name' => 'drinks',
            'link' => 'drinks',
            'instance' => $drinks, ],
          [
            'name' => 'foods',
            'link' => 'foods',
            'instance' => $foods, ],
          [
            'name' => 'venues',
            'link' => 'venues',
            'instance' => $venues, ],
          [
            'name' => 'activities',
            'link' => 'activities',
            'instance' => $activities, ],
      ]

    ])
    @endview_panel
@endsection
