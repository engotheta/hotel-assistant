<div class="modal fade" id="drinksModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
              <h5 class="modal-title system-text ">Select the Drink </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <div class="list-group drink-selector">
                <?php $n=1; ?>
                @forelse ($drinks as $drink)
                    <div   class="drink-option list-group-item list-group-item-action" data-dismiss="modal">
                      <span class="dark round "> {{ $n++ }} </span>
                      <span class="styem-text padded">{{ $drink->name }} </span>
                    </div>
                @empty
                    <a href="#" class="list-group-item list-group-item-action system-text">
                      you must have a drink! go and add a drink
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
