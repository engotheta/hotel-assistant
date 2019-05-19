@extends('layouts.with_panes')

@section('content')
  @yield('page')
  @include('partials.modals.hotel_name_modal')

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
