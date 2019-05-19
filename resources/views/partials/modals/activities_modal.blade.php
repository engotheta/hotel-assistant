@isset($activities)
<div class="modal fade" id="activitiesModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title system-text " id="editDepartment">Select an Activity to continue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="list-group">
              <?php $n=1; ?>
              @forelse ($activities as $activity)
                    <a href="{{  url($functions->getLink('activities',$activity,$branch,$department).'/edit') }}"
                      class="list-group-item list-group-item-action action-dependant-link"
                      data-action="edit">
                      <span class="dark round "> {{ $n++ }} </span>
                      <span class="system-text padded">{{ $activity->name }} </span>
                    </a>
              @empty
                  <a href="#" class="list-group-item list-group-item-action system-text">
                    you must have an activity! add an activity
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
