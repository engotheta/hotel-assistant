@isset($branches)
<div class="modal fade" id="branchesModal" tabindex="-1" role="dialog" aria-labelledby="branches" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

          <div class="modal-header">
            <h5 class="modal-title system-text " id="AddBranch">Select a Branch to continue</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="list-group">
              <?php $n=1; ?>
              @forelse ($branches as $branch)
                  <a href="{{ url($functions->getLink('branches',$branch,null,null).'/edit') }}"
                    class="list-group-item list-group-item-action action-dependant-link"
                    data-action="edit">
                    <span class="dark round "> {{ $n++ }} </span>
                    <span class="system-text padded">{{ $branch->name }} </span>
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
</div>
@endisset
