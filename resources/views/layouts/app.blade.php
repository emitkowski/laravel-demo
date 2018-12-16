<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @section('title')
            {{config('app.name') }}
        @show
    </title>

    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{asset('css/utility-core.css')}}" rel="stylesheet">
    <script>
        window.localStorage.setItem('token', @json(auth()->user()->api_token));
    </script>


    <script type="text/javascript">
        // Fix for Firefox autofocus CSS bug
        // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
    </script>
    @yield('styles')
</head>

<body class="skin-default">


<div class="preloader">
    <div class="loader_img"><img src="/images/loader.gif" alt="loading..." height="64" width="64"></div>
</div>

@include('partials.nav')

<div id="app" class="wrapper row-offcanvas row-offcanvas-left" v-cloak>

    <aside class="left-side sidebar-offcanvas">
        @include('partials.left-menu')
    </aside>

    <aside class="right-side">

        @include('partials.breadcrumbs.main')

        <div class="container" style="max-width:100%">

            @include('partials.alert')

            @yield('content')
        </div>
    </aside>

</div>

@yield('tabs_accordions')

<div id="qn"></div>

<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<script src="{{asset('js/vendor.js')}}" type="text/javascript"></script>

@yield('scripts')

</body>
</html>