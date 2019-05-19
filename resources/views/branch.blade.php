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
<div class="container fit-child">
    <div class="card">
        <div class="card-header system-text">
          <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> Departments </span>
        </div>

        <div class="card-body">

            @include('partials.messages')

            <div class="list-group">
              @forelse ($departments as $dep)
                    <a href="{{ url($functions->getLink('departments',$dep,$branch,null)) }}" class="list-group-item list-group-item-action">
                      {{ $dep->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have departments! add a department
                  </a>
              @endforelse
            </div>

            <hr class="dividing-line">

            <div class="list-group">
              @forelse ($activities as $activity)
                  <a href="{{url($functions->getLink('activities',$activity,$branch,null).'/start')}}" class="list-group-item list-group-item-action">
                    {{ $activity->name }}
                  </a>
              @empty

              @endforelse
            </div>

        </div>
    </div>
</div>
@endsection
