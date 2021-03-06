<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>RELES - Платформа дистанционного обучения</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    @stack('links')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('head')
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        @yield('styles')
    </style>
</head>
<body>
<div class="modal fade bd-example-modal-lg" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">
            </div>
        </div>
    </div>
</div>

<div class="container">
    <header>
        @include('layouts.main.header')
        @yield('topMenu')
    </header>
    <main role="main">
        @include('layouts.main.notice')
        @yield('content')
    </main>
    <footer>
        @include('layouts.main.footer')
        @yield('footer')
    </footer>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
