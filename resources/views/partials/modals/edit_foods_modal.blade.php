<div class="modal fade" id="editFoodsModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="editDepartment">Select an Venue from {{ $branch->name}} to Edit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <?php
              $department = isset($department)? $department:null;
              $branch = isset($branch)? $branch:null;
           ?>
          <div class="menu modal-header" id="editDepartment">
            <a class="menu-option" href="{{url($functions->getLink('foods',null,$branch,$department).'/edit-many')}}">
              <?php echo $themify_icons['edit-many']['tag'] ?>
              <span class="system-text"> Add Many  </span>
            </a>
          </div>

          <div class="modal-body">

            <div class="list-group">
              @forelse ($foods as $food)
                    <a href="{{ url($functions->getLink('foods',$food,$branch,$department).'/edit')}}" class="list-group-item list-group-item-action">
                      {{ $food->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have a food! add a food
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
