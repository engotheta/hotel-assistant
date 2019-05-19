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
<div class="card">

        <div class="card-header system-text">
          <?php  echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> Foods </span>
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

              @foreach($foods as $food)
                  <?php
                    array_push($temp,$food->branch_id);
                    $n++;

                    $amount = 0;
                    foreach ($food->loans->where('complete',0) as $loan) {
                       $amount += $loan->amount - $loan->paid;
                    }

                    $active = ($food->stock)? 'model-status-inline':'model-status-inactive';
                    $remarks = count($food->remarks->where('solved',0))? 'has-remarks':'has-no-remarks';

                    $content =' ';
                    $content .= count($food->loans->where('complete',0)) ? 'Has a unpaid loan of $amount! ':'';
                    $content .= ($food->stock)? '':'Currently it is out of stock!';
                    $content .= count($food->remarks->where('solved',0))? 'Has unresolved remarks.':' food is good.';
                  ?>

                  @if($temp[count($temp)-2]!=$food->branch_id)
                  <h5 class="modal-header category text">
                    {{$food->branch->name}}
                  </h5>

                  <div class="row flex-container index-stocked-row rows-header">
                      <span class="col-1 index row-index ">
                      </span>

                      <div class='col field-header index-stocked-field-group ' >
                          <div class="name-field">
                            <span class="name center-text"><?php echo $themify_icons['foods']['tag'] ?> </span>
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
                        <a class="name" href="{{url($functions->getLink('foods',$food,$branch,$department).$show)}}">
                            {{ $food->name }}
                        </a>
                      </div>
                      <div class="stock-field card-text text">
                          {{$food->stock}}
                      </div>
                      <div class="price-field text">
                          <span class="money"> {{$food->price}} </span>
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
