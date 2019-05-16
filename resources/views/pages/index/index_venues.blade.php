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
    $nav_bar_items += ['model' => 'venues'];

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
          <span class="text"> Venues </span>
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
              @foreach($venues as $venue)
                  <?php array_push($temp,$venue->branch_id); ?>
                  @if($temp[count($temp)-2]!=$venue->branch_id)
                  <h5 class="modal-header category text">
                    {{$venue->branch->name}}
                  </h5>
                  @endif

                  <?php array_push($temp2,$venue->floor); ?>
                  @if($temp2[count($temp2)-2]!=$venue->floor)
                    <h6 class="modal-header sub-category text">
                      floor {{$venue->floor}}
                    </h6>
                  @endif

                    <div class="card model model-index venue-card model-card-medium ">
                      <div class="card-body">

                        <?php
                        $active = ($venue->active)? '':'model-status-inactive';
                        $remarks = count($venue->remarks->where('solved',0))? 'has-remarks':'has-no-remarks';
                        $content =' ';
                        $content .= count($venue->loans->where('complete',0)) ? 'Has a unpaid loan! ':'';
                        $content .= count($venue->remarks->where('solved',0))? 'Has unresolved remarks.':' Works fine.';
                        ?>

                        <button class="model-status has-tip {{ $active. ' '. $remarks }}" data-tippy-content="{{$content}}">
                          <span> {{ count($venue->remarks->where('solved',0)) }} </span>
                        </button>

                        <h5 class="card-title text">
                          <?php $show = '/show'; ?>
                          <a href="{{url($functions->getLink('venues',$venue,$branch,$department).$show)}}">
                            <?php echo $themify_icons['venues']['tag'] ?>  {{ $venue->name }}
                          </a>
                        </h5>

                        <p class="card-text text">
                           <?php echo $themify_icons['price']['tag'] ?> <span class="money"> {{$venue->weekday_price}} </span>
                        </p>

                        <p class="card-text text">
                           <?php echo $themify_icons['price']['tag'] ?> <span class="money"> {{$venue->weekend_price}} </span>
                        </p>

                        <p class="card-text text">
                          <?php echo $themify_icons['capacity']['tag'] ?> {{$venue->capacity}}
                        </p>

                        @if(count($venue->loans->where('complete',0)))
                        <hr>
                        <div class="row no-gutter loans">
                            <?php
                            $amount = 0;
                            foreach ($venue->loans->where('complete',0) as $loan) {
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
