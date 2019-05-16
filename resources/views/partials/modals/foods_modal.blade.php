<div class="modal fade" id="foodsModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title system-text ">Select the Food </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="list-group food-selector">
                <?php $n=1; ?>
                @forelse ($foods as $food)
                    <div   class="food-option list-group-item list-group-item-action" data-dismiss="modal">
                      <span class="dark round "> {{ $n++ }} </span>
                      <span class="styem-text padded">{{ $food->name }} </span>
                    </div>
                @empty
                    <a href="#" class="list-group-item list-group-item-action system-text">
                      you must have a food! go and add a food
                    </a>
                @endforelse
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
