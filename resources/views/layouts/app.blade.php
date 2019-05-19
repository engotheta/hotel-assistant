<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <!--[if lt IE 9]><script language="javascript" type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('packages\dropzone\min\dropzone.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/themify-icons/themify-icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/fontello/css/ha.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/fontello/css/animation.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/smartphoto/css/smartphoto.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('packages/tippy/css/light.css') }}" rel="stylesheet" type="text/css">

</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
          @yield('nav_bar')
        </nav>

        <main class="py-4 relative">
          @yield('contents')
        </main>

    </div>
</body>
<!-- Scripts -->
<script type="text/javascript" src="{{ asset('packages\bootstrap-4.3.1\js\src\index.js')}}" ></script>
<script type="text/javascript" src="{{ asset('js\functions.js')}}" ></script>
<script type="text/javascript" src="{{ asset('js\navigation.js')}}" ></script>
<script type="text/javascript" src="{{ asset('js\events.js')}}" ></script>
<script type="text/javascript" src="{{ asset('packages\dropzone\min\dropzone.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('packages\tocca\Tocca.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('packages\smartphoto\js\smartphoto.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('packages\popper\js\popper.min.js')}}" ></script>
<script type="text/javascript" src="{{ asset('packages\tippy\js\index.all.min.js')}}" ></script>
</html>
