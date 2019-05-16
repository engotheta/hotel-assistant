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
    $nav_bar_items += ['model' => 'members'];
    $nav_bar_items += ['instance' => $member];

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
          <span class="text"> Member </span>
        </div>

        <div class="card-body">

            @include('partials.messages')

            <div class="menu modal-header" id="editDepartment">
              <a class="menu-option" >
                <i class="icon fi ti-wand "> </i>
                <span class="system-text"> Option 1 </span>
              </a>
            </div>

            <div class="modal-body fit-child">

                <h5 class="modal-header category text">
                    <?php echo $themify_icons['members']['tag'] ?>  {{ $member->name }}
                </h5>

                <div class=" model model-show ">
                  <div class="card-body">

                    @if($member->email)
                    <p class="card-text text">
                       <?php echo $themify_icons['role']['tag'] ?>
                       <span> Role   </span>
                       <span class="strong"> {{$member->role->name}} </span>
                    </p>
                    @endif

                    <p class="card-text text">
                       <?php echo $themify_icons['gender']['tag'] ?>
                       <span> Gender   </span>
                       <span class="strong"> {{$member->gender}} </span>
                    </p>

                    <p class="card-text text">
                       <?php echo $themify_icons['title']['tag'] ?>
                       <span> Title   </span>
                       <span class="strong"> {{$member->title->name}} </span>
                    </p>

                    @if($member->department_id)
                    <p class="card-text text">
                       <?php echo $themify_icons['departments']['tag'] ?>
                       <span> Department   </span>
                       <span class="strong"> {{$member->department->name}} </span>
                    </p>
                    @endif


                    @if($member->address_id OR $member->phone OR $member->email)
                    <br>
                    <h6 class="sub-category"> Contact information </h6>
                    <hr>

                    @if($member->address_id)
                    <p class="card-text text">
                       <?php echo $themify_icons['address']['tag'] ?>
                       <span> Physical Address   </span>
                       <span class="strong"> {{$member->address->name}} </span>
                    </p>
                    @endif

                    @if($member->phone)
                    <p class="card-text text">
                       <?php echo $themify_icons['phone']['tag'] ?>
                       <span> Phone number   </span>
                       <span class="strong"> {{$member->phone}} </span>
                    </p>
                    @endif

                    @if($member->email)
                    <p class="card-text text">
                       <?php echo $themify_icons['email']['tag'] ?>
                       <span> Email   </span>
                       <span class="strong"> {{$member->email}} </span>
                    </p>
                    @endif
                    @endif

                    <br>
                    <h6 class="sub-category"> Finance </h6>
                    <hr>

                    @if($member->salary)
                    <p class="card-text text">
                       <?php echo $themify_icons['money']['tag'] ?>
                       <span> Salary   </span>
                       <span class="strong"> {{$member->salary}} </span>
                    </p>
                    @endif

                    @if(count($member->loans->where('complete',0)))
                        <?php
                            $amount = 0;
                            foreach ($member->loans->where('complete',0) as $loan) {
                               $amount += $loan->amount - $loan->paid;
                            }
                        ?>
                        <p class="card-text text">
                             <?php echo $themify_icons['unpaid-loans']['tag'] ?>
                             <span> Standout Loan   </span>
                             <span class="strong">  {{ $amount }}  </span>
                        </p>
                    @endif

                    @if(($last = $member->salaries->where('complete',1)->sortByDesc('id')->first()))
                    <p class="card-text text">
                       <?php echo $themify_icons['price']['tag'] ?>
                       <span> Last paid   </span>
                       <span class="strong"> {{$last->updated_at}} </span>
                    </p>
                    @endif

                    <br>
                    <h6 class="sub-category"> Status </h6>
                    <hr>

                    @if($member->active)
                    <p>
                      <?php echo $themify_icons['active']['tag'] ?>
                      <span> The member is currently active </span>
                    </p>
                    @endif
                    @if(!$member->active)
                    <p>
                      <?php echo $themify_icons['inactive']['tag'] ?>
                      <span> The member is currently not active </span>
                    </p>
                    @endif

                    @if(count($member->remarks->where('solved',0)))
                    <h6 class="sub-category"> Remarks </h6>
                    <hr>
                        @foreach($member->remarks->where('solved',0) as $remark)
                        <p class="card-text text">
                            <?php echo $themify_icons['details']['tag'] ?>
                            <span class="text"> {{ $remark->remark }}</span>
                        <p>
                        @endforeach
                    @endif

                  </div>
                </div>

                @if(count($member->pictures))
                <br>
                <h6 class="sub-category"> Member Images </h6>
                <hr>
                <div class="center_txt">
                  <div class="images-display" id="memberImagesDisplayOld">
                    @foreach($member->pictures as $pic)
                    <div class="thumbnail">
                      <a href="{{ $pic->picture }}" class='js-smartphoto ' data-caption="{{ $pic->details }}" data-id="{{ $pic->id }}" data-group="{{ $member->name}}">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </a>
                    </div>
                    @endforeach
                  </div>
                </div>
                @endif

          </div>
      </div>

      <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
          </a>
      </div>

</div>
@endsection
