<div class="modal fade" id="deleteFoodsModal" tabindex="-1" role="dialog" aria-labelledby="foods" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddFood">Select a Food to Delete</h5>
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
              @forelse ($foods as $food)
                    <a href="{{ url($functions->getLink('foods',$food,$branch,$department).'/delete')}}" class="list-group-item list-group-item-action">
                      {{ $food->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have foods! add a food
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
