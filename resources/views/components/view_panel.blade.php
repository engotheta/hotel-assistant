<div  class="container fit-child">

  <div class="card fit-child">
      <div class="card-header">
        <?php
          echo $item_icon = isset($themify_icons['view panel'])? $themify_icons['view panel']['tag']: '';
         ?>
          <span class="text stystem-text">   View Panel </span>
       </div>

      <div class="card-body fit-child" >
        <div class="list-group">
          @foreach($items as $item)
            <a href="{{url($item['link'])}}" class="list-group-item list-group-item-action border-bottom fit-parent">
                @isset($themify_icons[$item['name']])
                    <?php echo $themify_icons[$item['name']]['tag']; ?>
                @endisset
                <span class="text stystem-text"> {{$item['name']}}</span>
                <span class="badge badge-primary right">{{count($item['instance'])}}</span>
            </a>
          @endforeach
        </div>

      </div>


  </div>
</div>
