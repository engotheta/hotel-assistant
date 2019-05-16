<div class="modal fade" id="deleteDrinksModal" tabindex="-1" role="dialog" aria-labelledby="drinks" aria-hidden="true">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddDrink">Select a Drink to Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <?php
                $department = isset($department)? $department:null;
                $branch = isset($branch)? $branch:null;
                $drink = isset($drink)? $drink:null;
             ?>

            <div class="list-group">
              @forelse ($drinks as $drink)
                    <a href="{{ $functions->getLink('drinks',$drink,$branch,$department).'/delete'}}" class="list-group-item list-group-item-action">
                      {{ $drink->name }}
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have drinks! add a drink
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
