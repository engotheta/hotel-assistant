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
          <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
          <span class="text"> Members </span>
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
              @foreach($members as $member)
                  <?php array_push($temp,$member->branch_id); ?>
                  @if($temp[count($temp)-2]!=$member->branch_id)
                  <h5 class="modal-header category text">
                    {{$member->branch->name}}
                  </h5>
                  @endif

                  @if($member->title_id)
                  <?php array_push($temp2,$member->title_id); ?>
                  @if($temp2[count($temp2)-2]!=$member->title_id)
                    <h6 class="modal-header sub-category text">
                       {{$member->title->name}}
                    </h6>
                  @endif
                  @endif

                    <div class="card model model-index member-card model-card-medium ">
                      <div class="card-body">

                        <?php
                          $logable = ($member->email) ? 'is-logable':'';
                          $admin = ($member->role->name == 'admin') ? 'is-admin':'';
                          $loan = count($member->loans->where('complete',0))? 'model-status-loan':'';
                          $content =' ';
                          $content .= ($member->email) ? 'Can login as ':'';
                          $content .= ($member->role->name == 'admin' )? 'an Admin, ':'';
                          $content .= (($member->role->name == 'admin') AND !$member->email)? 'but should setup an email to be able login, ':'';
                          $content .= ($member->email AND !($member->role->name == 'admin'))? 'an ordinary user, ':'';
                          $content .= count($member->loans->where('complete',0))? 'has a unpaid loan! ':'';
                          $content .= count($member->remarks->where('solved',0))? 'and has remarks':'';
                          $content .= ($content==' ')? 'This member is Ok':'';
                         ?>
                        <button class="model-status has-tip {{ $logable.' '.$admin. ' '.$loan }}" data-tippy-content="{{$content}}">
                            @if($member->role->name == 'admin') <small> Ad </small> @endif
                            @if(($member->role->name == 'user') AND $member->email) <small> Us </small> @endif
                            @if(($member->role->name == 'user') AND !$member->email) <small> M </small> @endif
                        </button>

                        <h5 class="card-title text">
                          <?php $show = '/show'; ?>
                          <a href="{{url($functions->getLink('members',$member,$branch,$department).$show)}}">
                              <?php echo $themify_icons['members']['tag'] ?>
                              <span> {{ $member->name }} </span>
                          </a>
                        </h5>

                        <p class="card-text text">
                           <?php echo $themify_icons['gender']['tag'] ?>
                           <span class="text"> {{$member->gender}} </span>
                        </p>

                        @if($member->title)
                        <p class="card-text text">
                             <?php echo $themify_icons['title']['tag'] ?>
                             <span> {{ $member->title->name }}  </span>
                        </p>
                        @endif

                        @if($member->department_id AND 0)
                        <p class="card-text text">
                             <?php echo $themify_icons['departments']['tag'] ?>
                             <span> {{ $member->department->name }}  </span>
                        </p>
                        @endif

                        @if(!$member->department_id AND 0)
                        <p class="card-text text">
                             <?php echo $themify_icons['departments']['tag'] ?>
                             <span> Not specified  </span>
                        </p>
                        @endif

                        <p class="card-text text">
                            <?php echo $themify_icons['money']['tag'] ?>
                            <span class='money'> {{$member->salary}} </span>
                        </p>

                        @if($member->email OR $member->phone)
                        <hr>
                        <div class="row no-gutter features">
                            @if($member->phone)
                            <div class="center-text fit-child">
                                <?php echo $themify_icons['phone']['tag'] ?>
                                 <span> {{ $member->phone }}  </span>
                            </div>
                            @endif
                            @if($member->email AND !$member->phone)
                            <div class="center-text fit-child">
                                <?php echo $themify_icons['email']['tag'] ?>
                                 <span> {{ $member->email }}  </span>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if(count($member->loans->where('complete',0)))
                        <hr>
                        <div class="row no-gutter loans">
                            <?php
                                $amount = 0;
                                foreach ($member->loans->where('complete',0) as $loan) {
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
