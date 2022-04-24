<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fibonashi')</title>
    <!-- Scripts -->
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script type="text/javascript" src="{{ asset('js/jquery.min.js') }}" defer></script> <!-- internet was lost, so I have to use file instead of CDN -->
    <script type="text/javascript" src="{{ asset('js/core.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/header.css') }}" rel="stylesheet">
    <link href="{{ asset('css/core.css') }}" rel="stylesheet">
    @stack('styles')
    @guest
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
    @endguest
    @stack('scripts')
</head>
<body>
    @include('partials.header')
    @guest
        <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
        @include('partials.auth.login-viewer')
    @endguest
    <main class="relative">
        @yield('content')
    </main>
</body>
</html>