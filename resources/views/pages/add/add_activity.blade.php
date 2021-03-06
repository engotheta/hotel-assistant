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
  <form method="POST"  action="{{$functions->getLink('activities',null,$branch,$department)}}" enctype="multipart/form-data">
    @csrf

      <div class="card-header system-text">
        <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: ''; ?>
        <span class="text"> {{$branch->name}} </span>
      </div>

      <div class="card-body">

            @include('partials.messages')

            <div class="modal-header">
              <h5 class="modal-title system-text " id="AddBranch">
                Add a new Activity to {{ $branch->name}}'s branch
              </h5>
            </div>

            <div class="modal-body">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="activityName"> Name </span>
                    </div>
                    <input required type="number" value="{{ $branch->id }}" name="branch_id" class="form-control none" hidden>
                    <input required type="text" name="name" class="form-control" placeholder="Activity's like pooltable" aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="activityName"> Price </span>
                    </div>
                    <input required type="number" name="price" class="form-control"  aria-label="branchname" aria-describedby="basic-addon1">
                </div>

                <h5 class="section-title stystem-text"> Possible Transaction Types </h5>
                <small class=""> uncheck all the transactions which can't take place for the activity</small>
                <hr class="dividing-line">

                <div class="row fit-child">
                  @foreach($transaction_types as $transaction_type)
                    <div class="input-group mb-3 col-sm-6">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <input checked name="transaction_type_{{$transaction_type->id}}" value="{{$transaction_type->id}}" type="checkbox" aria-label="Checkbox for following text input">
                        </div>
                      </div>
                      <span class="form-control" aria-label="Text input with checkbox"> {{$transaction_type->name}}</span>
                    </div>
                  @endforeach
                </div>

                <h4 class="section-title"> Optional Fields </h4>
                <hr class="dividing-line">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                    </div>
                    <select name="contact_person_id" class="custom-select" id="departmentContactPersonId">
                      <option value="" selected> None </option>

                      @foreach($members as $member)
                        <option value="{{$member->id}}"> {{$member->name}} </option>
                      @endforeach

                    </select>
                </div>

                <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="images">Activity's Pictures</label>
                  </div>
                  <div class="custom-file">
                    <input name="images[]" id="activityImages" type="file" class="thumbnail-creator custom-file-input"
                     data-multiple-caption="{count} files selected" data-display="#activityImagesDisplay"
                     data-event="onchange"  multiple>
                  </div>
                </div>
                <div class="center_txt">
                  <div class="images-display" id="activityImagesDisplay"></div>
                </div>

                <div class="input-group field">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> Activity Details </span>
                    </div>
                    <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
                </div>

            </div>
        </div>

        <div class="card-footer input-group field center-text flex-container flex-between">
          <a href="{{$functions->getReturnLink($branch,$department)}}" >
            <button type="button" class="btn btn-secondary" >
              {{$functions->goBackTo($branch,$department)}}
            </button>
          </a>
          <input class="btn btn-primary" type="submit"  value="Add The activity">
        </div>

  </form>
</div>
@endsection
