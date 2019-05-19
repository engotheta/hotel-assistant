@isset($venues)
<div class="modal fade" id="venuesModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title system-text ">Select a Venue to continue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="list-group">
              <?php $n=1; ?>
              @forelse ($venues as $venue)
                    <a href="{{ url($functions->getLink('venues',$venue,$branch,$department).'/edit') }}"
                      class="list-group-item list-group-item-action action-dependant-link"
                      data-action="edit">
                      <span class="dark round "> {{ $n++ }} </span>
                      <span class="system-text padded">{{ $venue->name }} </span>
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
</div>
@endisset
