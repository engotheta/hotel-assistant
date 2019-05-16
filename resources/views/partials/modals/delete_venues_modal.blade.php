<div class="modal fade" id="deleteVenuesModal" tabindex="-1" role="dialog" aria-labelledby="venues" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddVenue">Select an Venue to Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <?php
              $department = isset($department)? $department:null;
              $branch = isset($branch)? $branch:null;
             ?>

            <div class="list-group">
              @forelse ($venues as $venue)
                    <a href="{{  url($functions->getLink('venues',$venue,$branch,$department).'/delete') }}" class="list-group-item list-group-item-action">
                      {{ $venue->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have a venue! add a venue
                  </a>
              @endforelse
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

          </div>
        </div>
      </div>
    </form>
</div>
