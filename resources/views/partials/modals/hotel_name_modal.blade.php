<div class="modal fade" id="hotelNameModal" tabindex="-1" role="dialog" aria-labelledby="setHotelName" aria-hidden="true">
  <form method="POST" name="set_hotel" action="{{route('settings.store')}}">
    @csrf

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title system-text " id="setHotelName">Set hotel name</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text system-text" id="basic-addon1"> Name</span>
                    <input type="text" name="name" value="hotel_name" class="form-control" hidden>
                </div>
                <input type="text" name="value" class="form-control" placeholder="hotel name" aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input class="btn btn-primary" name="submit_settings" type="submit"  value="Save">
          </div>
        </div>
      </div>

  </form>
</div>
