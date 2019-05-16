<?php
    $nav_bar_items = ['hotel'=>$hotel];

    if(isset($department)){
      $scope = 'department';
    }elseif(isset($branch)){
      $scope = 'branch';
    }else{
      $scope = 'home';
    }

    if(isset($branch)) $nav_bar_items += ['branch' => $branch];
    if(isset($department)) $nav_bar_items += ['department' => $department];
    $nav_bar_items += ['model' => 'activities'];

    $department = isset($department)? $department:null;
    $branch = isset($branch)? $branch:null;

 ?>

@extends('layouts.'.$scope)

@section('nav_bar')
    @nav_bar($nav_bar_items)
    @endnav_bar
@endsection

@section('page')
<div class="card">

      <div class="card-header system-text">
        <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
        <span class="text"> Activities </span>
      </div>

      <div class="card-body">

          @include('partials.messages')

          <div class="menu modal-header" id="editDepartment">
            <a class="menu-option" >
              <i class="icon fi ti-wand "> </i>
              <span class="system-text"> Option 1 </span>
            </a>
          </div>


          <div class="modal-body model-container">

            <?php $temp = array('a'); $temp2 = array('b');?>
            @foreach($activities as $activity)

                <?php array_push($temp,$activity->branch_id); ?>
                @if($temp[count($temp)-2]!=$activity->branch_id)
                <h5 class="modal-header category text">
                  {{$activity->branch->name}}
                </h5>
                @endif

                <div class="card model model-index activity-card model-card-medium ">
                  <div class="card-body">

                      <?php
                        $active = ($activity->active)? '':'model-status-inactive';
                        $remarks = count($activity->remarks->where('solved',0))? 'has-remarks':'has-no-remarks';

                        $content =' ';
                        $content .= count($activity->loans->where('complete',0)) ? 'Has a unpaid loan! ':'';
                        $content .= count($activity->remarks->where('solved',0))? 'Has unresolved remarks.':' Works fine.';
                      ?>

                      <button class="model-status has-tip {{ $active. ' '. $remarks }}" data-tippy-content="{{$content}}">
                        <span> {{ count($activity->remarks->where('solved',0)) }} </span>
                      </button>

                      <h5 class="card-title text">
                        <?php $show = '/show'; ?>
                        <a href="{{url($functions->getLink('activities',$activity,$branch,$department).$show)}}">
                            <?php echo $themify_icons['activities']['tag'] ?>  {{ $activity->name }}
                        </a>
                      </h5>

                      <p class="card-text text">
                         <?php echo $themify_icons['price']['tag'] ?> <span class="money"> {{$activity->price}} </span>
                      </p>


                      @if(count($activity->loans->where('complete',0)))
                      <hr>
                      <div class="row no-gutter loans">
                          <?php
                              $amount = 0;
                              foreach ($activity->loans->where('complete',0) as $loan) {
                                 $amount += $loan->amount - $loan->paid;
                              }
                          ?>
                          <div class="center-text fit-child">
                              <?php echo $themify_icons['unpaid-loans']['tag'] ?>
                               <span> {{ $amount }}  </span>
                          </div>
                      </div>
                      @endif

                  </div>
                </div>

            @endforeach
        </div>

    </div>

    <div class="card-footer input-group field center-text flex-container flex-between">
        <a href="{{$functions->getReturnLink($branch,$department)}}" >
          <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
        </a>
    </div>

</div>
@endsection
