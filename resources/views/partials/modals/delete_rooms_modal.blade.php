<div class="modal fade" id="deleteRoomsModal" tabindex="-1" role="dialog" aria-labelledby="rooms" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddRoom">Select a Room to Delete</h5>
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
              @forelse ($rooms as $room)
                    <a href="{{ url($functions->getLink('rooms',$room,$branch,$department).'/delete')  }}" class="list-group-item list-group-item-action">
                      {{ $room->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have rooms! add a room
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
