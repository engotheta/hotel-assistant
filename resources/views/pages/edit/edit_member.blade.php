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
    <form method="POST"  action="{{url($functions->getLink('members',$member,$branch,$department))}}" enctype="multipart/form-data">
        @csrf
        {{method_field('PUT')}}

        <div class="card-header system-text">
          <i class="icon ti ti-pencil"> </i>
          <span class='system-text text'>Edit  {{ $member->name }}'s information  </span>
        </div>

        <div class="menu modal-header" id="editDepartment">
          <a class="menu-option" href="{{url($functions->getLink('members',null,$branch,$department).'/edit-many')}}">
            <i class="icon fi ti-wand "> </i>
            <span class="system-text"> Edit Many  </span>
          </a>
        </div>

        <div class="card-body">

              @include('partials.messages')

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="departmentName"> Name </span>
                  </div>
                  <input  type="text" name="name" class="form-control" value="{{ $member->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Gender </label>
                  </div>
                  <select required name="gender" class="custom-select" id="departmentContactPersonId">
                    <option value="male" <?php echo $selected = ($member->gender == 'male') ? 'selected':'' ?>> Male </option>
                    <option value="female" <?php echo $selected = ($member->gender == 'female') ? 'selected':'' ?>> Female </option>
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Move to another Branch</label>
                  </div>
                  <select required name="branch_id" class="custom-select" id="branch">
                      @foreach($branches as $bra)
                      <?php $selected =  $bra->id == $member->branch_id?  'selected':''; ?>
                      <option value="{{$bra->id}}" {{$selected}}> {{$bra->name}} </option>
                      @endforeach
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Member Title</label>
                  </div>
                  <select name="title_id" class="custom-select" id="MemberTileId">
                    @foreach($titles as $title)
                    <?php  $selected =  $title->id == $member->title_id?  'selected':'';  ?>
                    <option value="{{$title->id}}" {{$selected}}> {{$title->name}} </option>
                    @endforeach
                  </select>
              </div>

              <small> Members role in relation to this system usage privelages</small>
              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Member Role</label>
                  </div>
                  <select name="role_id" class="custom-select" id="MemberRoleId">
                      @foreach($roles as $role)
                      <?php $selected =  $role->id == $member->role_id?  'selected':''; ?>
                      <option value="{{$role->id}}" {{$selected}}> {{$role->name}} </option>
                      @endforeach
                  </select>
              </div>



              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="memberName"> Salary </span>
                  </div>
                  <input required type="number" value="{{$member->salary}}" name="salary" class="form-control" aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <h4 class="section-title"> Optional Fields </h4>
              <hr class="dividing-line">

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Department</label>
                  </div>
                  <select name="department_id" class="custom-select" id="departmentContactPersonId">
                    <option value="" selected> None </option>
                    @foreach($departments as $dep)
                    <?php $selected =  $dep->id == $member->department_id?  'selected':''; ?>
                    <option value="{{$dep->id}}" {{$selected}}> {{$dep->name}} </option>
                    @endforeach
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="branchAddressId"> Member Address  </span>
                  </div>
                  <?php $add = ($member->address) ? $member->address->name:'' ?>
                  <input type="text" name="address" value="{{ $add }}" class="form-control"  aria-label="floor" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="Birth"> Date of Birth </span>
                  </div>
                  <input  type="date" name="birth" class="form-control" value="{{ $member->birth }}"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="phoneNumber"> Phone number </span>
                  </div>
                  <input  type="text" name="phone" value="{{$member->phone}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="email"> Email </span>
                  </div>
                  <input  type="email" name="email"  value="{{$member->email}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
              </div>

              <div class="input-group field mb-3">
                <div class="input-group-prepend">
                  <label class="input-group-text" for="images">Member's Pictures</label>
                </div>
                <div class="custom-file">
                  <input name="images[]" id="membersImages" type="file" class="thumbnail-creator custom-file-input"
                   data-multiple-caption="{count} files selected" data-display="#memberImagesDisplay"
                   data-event="onchange"  multiple>
                </div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="memberImagesDisplay"></div>
              </div>

              <div class="center_txt">
                <div class="images-display" id="memberImagesDisplayOld">
                  @foreach($member->pictures as $pic)
                  <div class="thumbnail">
                    <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                  </div>
                  @endforeach
                </div>
              </div>

          </div>

          <div class="card-footer input-group field center-text flex-container flex-between">
            <a href="{{ url($functions->getReturnLink($branch,$department))}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input class="btn btn-primary" type="submit"  value="Save Changes">
          </div>

    </form>
</div>
@endsection
