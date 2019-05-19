<div class="container fit-child">

  <div class="card fit-child">
      <div class="card-header admin-card-header">
        @isset($themify_icons['admin panel'])
           <?php  echo $themify_icons['admin panel']['tag'] ?>
        @endisset
        <span class="text"> Admin Panel </span>

       </div>

      <div class="card-body fit-child fit-parent">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif

          @isset($items)
            <div class="accordion" id="adminItems">

              @foreach($items as $item)
                <div class="card no-padding fit-child fit-parent">
                  <div class="card-header admin-item-card-header fit-parent border-bottom" data-toggle="collapse"
                      data-target="#{{ $item['name'] }}" aria-expanded="true" aria-controls="collapseOne">

                    <?php
                        echo $item_icon = isset($themify_icons[$item['name']])? $themify_icons[$item['name']]['tag']: '';
                     ?>
                    <span class='text'>    {{ $item['name'] }} </span>

                  </div>

                  <div id="{{ $item['name'] }}" class="collapse" aria-labelledby="headingOne" data-parent="#adminItems">
                    <div class="card-body">
                      <div class="list-group no-padding no-margin">
                        @foreach($item['actions'] as $action)
                          <?php
                               $link = isset($action['link']) ? $action['link']:'#' ;
                               $target = isset($action['link']) ? '':'data-toggle=modal' ;
                           ?>
                          <a class='link' href="{{$link}}">
                            <button type="button" class="list-group-item list-group-item-action action-trigger" {{$target}}
                              data-action="{{$action['name']}}" data-target="#{{$item['target']}}">
                                @isset($themify_icons[$action['name']])
                                   <?php  echo $themify_icons[$action['name']]['tag'] ?>
                                @endisset
                                <span class="text"> {{ $action['name'] }} </span>
                            </button>
                          </a>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach

          </div>
        @endisset

      </div>
  </div>
</div>
