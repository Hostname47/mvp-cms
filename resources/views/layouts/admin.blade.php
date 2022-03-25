<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Fibonashi')</title>
    
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
    <script type="text/javascript" src="{{ asset('js/core.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/admin/core.js') }}" defer></script>
    
    <!-- Styles -->
    <link href="{{ asset('css/core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/core.css') }}" rel="stylesheet">
    @stack('styles')
    @stack('scripts')
</head>
<body>
    @yield('left-panel')
    @yield('content')
    @include('partials.shared-things')
</body>
</html>