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

  <form method="POST"  action="{{ url($functions->getLink('members',$member,$branch,$department)) }}" enctype="multipart/form-data">
    @csrf
    {{method_field('DELETE')}}

        <div class="card-header system-text">
          <i class="icon ti ti-trash"> </i>
          <span class='system-text text'> Delete {{ $member->name }} from the branch </span>
        </div>

        <div class="card-body">
          @include('partials.messages')


              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                      <span class="input-group-text system-text" id="branchName"> Name </span>
                  </div>
                  <input readonly required type="text" name="name" class="form-control" value="{{ $member->name }}" aria-label="branchname" aria-describedby="basic-addon1">
              </div>


              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Gender </label>
                  </div>
                  <select readonly required name="gender" class="custom-select" id="departmentContactPersonId">
                    <option value="male" <?php echo $selected = ($member->gender == 'male') ? 'selected':'' ?>> Male </option>
                    <option value="female" <?php echo $selected = ($member->gender == 'female') ? 'selected':'' ?>> Female </option>
                  </select>
              </div>

              <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01"> Member Role</label>
                  </div>
                  <select readonly name="role_id" class="custom-select" id="departmentContactPersonId">

                    @foreach($roles as $role)
                     <?php
                        $selected =  $role->id == $member->role_id?  'selected':'';
                     ?>
                      <option value="{{$role->id}}" {{$selected}}> {{$role->name}} </option>
                    @endforeach

                  </select>
              </div>

                @if($member->salary)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="memberName"> Salary </span>
                      </div>
                      <input readonly required type="number" value="{{$member->salary}}" name="salary" class="form-control" aria-label="branchname" aria-describedby="basic-addon1">
                  </div>
                @endif

                @if($member->department_id)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> Department</label>
                      </div>
                      <select  readonly name="department_id" class="form-control" id="departmentContactPersonId">
                        <option value="" selected> None </option>

                        @foreach($departments as $department)
                        <?php
                           $selected =  $department->id == $member->department_id?  'selected':'';
                        ?>
                          <option value="{{$department->id}}" {{$selected}}> {{$department->name}} </option>
                        @endforeach

                      </select>
                  </div>
                @endif

                @if($member->address_id)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="branchAddressId"> Branch Address  </span>
                      </div>
                      <?php $add = ($member->address) ? $member->address->name:'' ?>
                      <input readonly type="text" name="address" value="{{ $add }}" class="form-control"  aria-label="floor" aria-describedby="basic-addon1">
                  </div>
                @endif

                @if($member->birth)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="Birth"> Date of Birth </span>
                      </div>
                      <input readonly  type="date" name="birth" class="form-control" value="{{ $member->birth }}"  aria-label="branchname" aria-describedby="basic-addon1">
                  </div>
                @endif

                @if($member->phone)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text system-text" id="phoneNumber"> Phone number </span>
                      </div>
                      <input readonly type="text" name="phone" value="{{$member->phone}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                  </div>
                @endif

              @if($member->email)
                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="email"> Email </span>
                    </div>
                    <input readonly type="email" name="email"  value="{{$member->email}}" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>
              @endif

              @if(count($member->pictures))
                <div class="center_txt">
                  <div class="images-display" id="memberImagesDisplayOld">

                    @foreach($member->pictures as $pic)
                    <div class="thumbnail">
                      <img class="centered-item-js relative" src="{{ $pic->picture }}" />
                    </div>
                    @endforeach

                  </div>
                </div>
              @endif

        </div>

          <div class="card-footer input-group field center-text flex-container flex-between">
            <a href="{{ $functions->getReturnLink($branch,$department)}}" >
              <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
            </a>
            <input  class="btn btn-primary" type="submit"  value="Delete this Member">
          </div>

    </form>
</div>

@endsection
