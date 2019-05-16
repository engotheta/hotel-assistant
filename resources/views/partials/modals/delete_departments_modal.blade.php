<div class="modal fade" id="deleteDepartmentsModal" tabindex="-1" role="dialog" aria-labelledby="departments" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">Select a Department to Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

              <?php
                $department_ = isset($department)? $department:null;
                $branch = isset($branch)? $branch:null;
               ?>

            <div class="list-group">
              @forelse ($departments as $dep)
                    <a href="{{ url($functions->getLink('departments',$dep,$branch,null).'/delete')}}" class="list-group-item list-group-item-action">
                      {{ $dep->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have a Department! add a department
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
