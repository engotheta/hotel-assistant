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
  <form method="POST"  action="{{$functions->getLink('branches',null,null,null)}}" enctype="multipart/form-data">
    @csrf

    <div class="card-header system-text">
      <?php echo $item_icon = isset($themify_icons['content panel'])? $themify_icons['content panel']['tag']: '';  ?>
      <span class="text"> Branches </span>
    </div>

    <div class="card-body">

            @include('partials.messages')

            <div class="modal-header">
              <h5 class="modal-title system-text " id="AddBranch">Add a new branch</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="branchName"> Name </span>
                    </div>
                    <input required type="text" name="name" class="form-control" placeholder="Branch Name" aria-label="branchname" aria-describedby="basic-addon1">

                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="branchAddressId"> Branch Address  </span>
                    </div>
                    <input type="text" name="address" class="form-control"  aria-label="floor" aria-describedby="basic-addon1" required>
                </div>

                <div class="input-group field mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text system-text" id="branchFloor"> Max of Floors  </span>
                    </div>
                    <input required type="number" min="0" name="floors" class="form-control"  aria-label="floor" aria-describedby="basic-addon1">
                </div>

                @isset($members)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01"> Contact Member </label>
                      </div>
                      <select name="contact_person_id" class="custom-select" id="branchContactPersonId">
                        <option value="" selected> None </option>
                        @foreach($members as $member)
                        <option value="{{$member->id}}"> {{$member->name}} </option>
                        @endforeach
                      </select>
                  </div>
                @endisset


                <h4 class="section-title"> Optional Fields </h4>
                <hr class="dividing-line">

                @isset($ahhahahahaha)
                  <div class="input-group field mb-3">
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choose Branch's Icon</button>
                        <div class="dropdown-menu">
                            @foreach($themify_icons as $icon)
                            <span class="dropdown-item"> <?php echo $icon['tag'] ?></span>
                            @endforeach
                        </div>
                      </div>
                      <input type="text" name="icon" class="form-control" aria-label="Text input with dropdown button">
                  </div>
                @endisset

                <div class="input-group field mb-3">
                  <div class="input-group-prepend">
                    <label class="input-group-text" for="images">Branch's Pictures</label>
                  </div>
                  <div class="custom-file">
                    <input name="images[]" id="branchimages" type="file" class="thumbnail-creator custom-file-input"
                     data-multiple-caption="{count} files selected" data-display="#branchesImagesDisplay"
                     data-event="onchange"  multiple>
                  </div>
                </div>
                <div class="center_txt">
                  <div class="images-display" id="branchesImagesDisplay"></div>
                </div>

                <div class="input-group field">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> Branch Details </span>
                    </div>
                    <textarea name="details" class="form-control" aria-label="With textarea"></textarea>
                </div>

          </div>
     </div>

     <div class="card-footer input-group field center-text flex-container flex-between">
         <a href="{{ $functions->getReturnLink($branch,$department) }}" >
           <button type="button" class="btn btn-secondary" >{{$functions->goBackTo($branch,$department)}}</button>
         </a>
       <input class="btn btn-primary" type="submit"  value="Add The Branch">
     </div>

  </form>
</div>
@endsection
