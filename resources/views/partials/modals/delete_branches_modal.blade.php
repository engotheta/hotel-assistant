<div class="modal fade" id="deleteBranchModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">Select a Branch to Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">

            <?php
              $department = isset($department)? $department:null;
              $branch_ = isset($branch)? $branch:null;
             ?>

            <div class="list-group">
              @forelse ($branches as $branch)
                    <a href="{{ url($functions->getLink('branches',$branch,null,null).'/delete')}}" class="list-group-item list-group-item-action">
                      {{ $branch->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have a branch! add a branch
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
