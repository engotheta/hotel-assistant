@extends('layouts.department')

@section('nav_bar')
    @nav_bar([
        'hotel'=>$hotel,
        'branch' => $branch,
        'department' => $department,
    ])
    @endnav_bar

@endsection

@section('page')
<div class="container fit-child">
    <div class="card">
        <div class="card-header system-text">
          <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> {{$department->name}} </span>
        </div>

        <div class="card-body">
            @include('partials.messages')

            <div class="list-group">
                @if(($incompletes = $department->businessdays->where('complete',0)))
                    @foreach($incompletes as $incomplete)
                    <?php $show = '/show'; ?>
                    <a href="{{url($functions->getLink('businessdays',$incomplete,$branch,$department).$show)}}" class="list-group-item list-group-item-action">
                      Continue {{ $incomplete->name }}
                    </a>
                    @endforeach
                @endif
                <a href="{{url($functions->getLink('businessdays',null,$branch,$department).'/add')}}" class="list-group-item list-group-item-action system-text">
                    New Businessday
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
