<div class="container main-menu">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <div class="nav-links">

              @isset($hotel)
                @if($hotel)
                   <a href="{{ route('home') }}" class="nav-item hotel-name text">
                    {{ $hotel->value }}
                   </a>

                @else
                    <i class="sep ti ti-angle-right "> </i>
                    <a href="#" class="nav-item hotel-name text system-text" data-toggle="modal" data-target="#hotelNameModal">
                       set hotel name
                     </a>
                @endif
              @endisset


              @isset($branch)
                <i class="sep ti ti-angle-right "> </i>
                <a href="/branches/{{$branch->slug}}" class="nav-item branch-name text"> {{ $branch->name }}</a>
              @endisset

              @isset($department)
                <i class="sep ti ti-angle-right "> </i>
                <a href="/departments/{{$department->slug}}/{{$branch->slug}}" class="nav-item text content-name">  {{ $department->name }}  </a>
              @endisset

              @isset($activity)
                <i class="sep ti ti-angle-right "> </i>
                <a href="" class="nav-item text content-name">  {{ $activity->name }}  </a>
              @endisset

              @isset($model)
                <i class="sep ti ti-angle-right "> </i>
                <a href="" class="nav-item text content-name">  {{ $model }}  </a>
              @endisset

              @isset($instance)
                <i class="sep ti ti-angle-right "> </i>
                <a href="" class="nav-item content-name text"> {{ $instance->name }}  </a>
              @endisset

          </div>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="">
                            Profile setting
                        </a>
                        <hr>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</div>
