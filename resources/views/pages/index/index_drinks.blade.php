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
    $nav_bar_items += ['model' => 'drinks'];

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
          <span class="text"> Drinks </span>
        </div>

        <div class="card-body">

            @include('partials.messages')

            <div class="menu modal-header" id="editDepartment">
              <a class="menu-option" >
                <i class="icon fi ti-wand "> </i>
                <span class="system-text"> Option 1 </span>
              </a>
            </div>

            <div class="modal-body stock-table">
                <?php
                    $temp = array('a');
                    $temp2 = array('b');
                    $n = 0;
                ?>

                @foreach($drinks as $drink)
                    <?php
                      array_push($temp,$drink->branch_id);
                      array_push($temp2,$drink->drink_type_id);
                      $n++;

                      $amount = 0;
                      foreach ($drink->loans->where('complete',0) as $loan) {
                         $amount += $loan->amount - $loan->paid;
                      }

                      $active = ($drink->stock)? 'model-status-inline':'model-status-inactive';
                      $remarks = count($drink->remarks->where('solved',0))? 'has-remarks':'has-no-remarks';

                      $content =' ';
                      $content .= count($drink->loans->where('complete',0)) ? 'Has a unpaid loan of $amount! ':'';
                      $content .= ($drink->stock)? '':'Currently it is out of stock!';
                      $content .= count($drink->remarks->where('solved',0))? 'Has unresolved remarks.':' drink is good.';
                    ?>

                    @if($temp[count($temp)-2]!=$drink->branch_id)
                    <h5 class="modal-header category text">
                      {{$drink->branch->name}}
                    </h5>

                    @endif

                    @if($temp2[count($temp2)-2]!=$drink->drink_type_id)
                      @if($drink->drink_type_id)
                      <h6 class="modal-header sub-category text">
                        {{$drink->drinkType->name." (".count($drinks->where('drink_type_id',$drink->drink_type_id)).")"}}
                      </h6>
                      @endif
                      <div class="row flex-container index-stocked-row rows-header">
                          <span class="col-1 index row-index ">   </span>
                          <div class='col field-header index-stocked-field-group ' >
                              <div class="name-field">
                                <span class="name center-text"><?php echo $themify_icons['drinks']['tag'] ?> </span>
                              </div>
                              <div class="stock-field">
                                <?php echo $themify_icons['stock']['tag'] ?>
                              </div>
                              <div class="price-field">
                                <?php echo $themify_icons['price']['tag'] ?>
                                <span> Tsh  </span>
                              </div>
                          </div>
                    </div>
                    @endif

                    <div class="row flex-container index-stocked-row">
                        <span class="col-1  row-index has-tip {{ $active. ' '. $remarks }}" data-tippy-content="{{$content}}">
                           {{ $n }}
                         </span>
                        <div class="col index-stocked-field-group">

                            <div class="name-field text">
                              <?php $show = '/show'; ?>
                              <a class="name" href="{{url($functions->getLink('drinks',$drink,$branch,$department).$show)}}">
                                  {{ $drink->name }}
                              </a>
                            </div>

                            <div class="stock-field card-text text">
                                {{$drink->stock}}
                            </div>

                            <div class="price-field text">
                                <span class="money"> {{$drink->price}} </span>
                            </div>

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
