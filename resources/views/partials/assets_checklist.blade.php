<div class="checklist">

      @if(isset($rooms))
      <div class="room-list row">
          <script type="text/javascript"> var rooms = {{json_encode($rooms)}} </script>
          @include('partials.modals.rooms_modal')
          @foreach($rooms as $room)
          <div class="room-list-item col-3">
              <input  id="{{'room_'.$room->id}}" data-option="#{{'roomOption_'.$room->id}}" name="room[]" value="{{$room->id}}" type="checkbox" >
              <span> {{$room->name}}</span>
          </div>
          @endforeach
      </div>
      @endif

      @if(isset($venues))
      <hr>
      <div class="venue-list row">
          <script type="text/javascript"> var venues = {{json_encode($venues)}} </script>
          @include('partials.modals.rooms_modal')
          @foreach($venues as $venue)
          <div class="venue-list-item col-4">
              <input id="{{'venue_'.$venue->id}}" data-option="#{{'venueOption_'.$venue->id}}" name="venue[]" value="{{$venue->id}}" type="checkbox" >
              <span> {{$venue->name}}</span>
          </div>
        @endforeach
      </div>
      @endif

      @if(isset($drinks))
      <hr>
      <div class="drink-list row">
          <script type="text/javascript"> var drinks = {{json_encode($drinks)}} </script>
          @include('partials.modals.drinks_modal')
          @foreach($drinks as $drink)
          <div class="drink-list-item col-4">
              <input id="{{'drink_'.$drink->id}}" data-option="#{{'drinkOption_'.$drink->id}}" name="drink[]" value="{{$drink->id}}" type="checkbox" >
              <span> {{$drink->name}}</span>
          </div>
        @endforeach
      </div>
      @endif

      @if(isset($foods))
      <hr>
      <div class="drink-list row">
          <script type="text/javascript"> var foods = {{json_encode($foods)}} </script>
          @include('partials.modals.foods_modal')
          @foreach($foods as $food)
          <div class="food-list-item col-4">
              <input id="{{'food_'.$food->id}}" data-option="#{{'foodOption_'.$food->id}}" name="food[]" value="{{$food->id}}" type="checkbox" >
              <span> {{$food->name}}</span>
          </div>
        @endforeach
      </div>
      @endif

</div>
