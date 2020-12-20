<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RELES - Платформа дистанционного обучения</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    @yield('head')
    <style>
        body {
            font-family: 'Nunito';
        }
        @yield('styles')
    </style>
</head>
<body>
@include('layouts.main.top_menu')
@yield('topMenu')
<main>
    <div class="container">
    @yield('content')
    </div>
</main>
<footer>
    @include('layouts.main.footer')
    @yield('footer')
</footer>
@yield('scripts')
</body>
</html>