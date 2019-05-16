@extends('layouts.app')


@section('contents')
  <div class="full-screen flex fixed pane-controls-no-js pane-controls">
    <span class="right-pane-control pane-control" data-toggle="pane" data-target="#admin_panel">
        <i class="ti ti-shift-right"> </i>
    </span>
    <span class="left-pane-control pane-control" data-toggle="pane" data-target="#view_panel">
        <i class="ti ti-shift-left"> </i>
    </span>
  </div>

  <div id="page" onswiperight="alert()" onswipeleft="function(e){alert('view panel')}">
    <div class="pane-no-js pane" id="admin_panel">
        @yield('admin_panel')
    </div>
    <div class="content-no-js pane " id="content">
        <div class="container fit-child"> @yield('content') </div>
    </div>
    <div class="pane-no-js pane" id="view_panel">
        @yield('view_panel')
    </div>
  </div>
@endsection
