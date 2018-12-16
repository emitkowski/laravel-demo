<!DOCTYPE html>
<html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @section('title')
            {{config('app.name') }}
        @show
    </title>

    <link href="/css/auth.css" rel="stylesheet">

</head>

<body id="sign-in">

<div id="app" v-cloak>
    @yield('content')
</div>

<script src="/js/app.js" type="text/javascript"></script>

</body>

</html>

