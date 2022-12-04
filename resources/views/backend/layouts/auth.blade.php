<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="Odie">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('images/logo-alt.webp') }}">
    <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('images/logo-alt.webp') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo-alt.webp') }}">

    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">

    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}"> -->
    @yield('styles')

    <!-- Scripts -->
    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
</head>
<body>

<div id="page-container">
    <main id="main-container">
        @yield('content')
    </main>
</div>
<!-- END Page Container -->

<!-- Codebase Core JS -->
<script src="{{ mix('js/codebase.app.js') }}"></script>

<!-- Laravel Scaffolding JS -->
<!-- <script src="{{ mix('js/laravel.app.js') }}"></script> -->

@yield('scripts')
</body>
</html>
