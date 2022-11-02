<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>@yield('title', 'Welcome') | {{ config('app.name') }}</title>

    <meta name="description" content="Odie">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicons/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicons/mstile-150x150.png') }}">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts and Styles -->
    @yield('css_before')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ mix('/css/codebase.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin.css')}}">

    <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
    <link rel="stylesheet" id="css-theme" href="{{ mix('/css/themes/corporate.css') }}">
    @yield('styles')

<!-- Scripts -->
    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
</head>
<body>

<div id="page-container" class="sidebar-o enable-page-overlay side-scroll page-header-fixed sidebar-inverse">
    @include('backend.includes.partials.sidebar')

    @include('backend.includes.partials.header')

    <main id="main-container">
        @yield('pre-content')
        <div class="content">
            @hasSection('breadcrumbs')
                <nav class="breadcrumb bg-white">
                    @yield('breadcrumbs')
                    <span class="breadcrumb-item active">@yield('breadcrumb-active')</span>
                </nav>
            @endif

            @hasSection('content-heading')
                <h2 class="content-heading">
                    @yield('content-heading')
                    <div class="float-right">@yield('content-header-action')</div>
                </h2>
            @endif

            @yield('content')
        </div>
    </main>

    @include('backend.includes.partials.footer')
</div>
<!-- END Page Container -->

<!-- Codebase Core JS -->
<script src="{{ mix('js/codebase.app.js') }}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>

<!-- Laravel Scaffolding JS -->
<script src="{{ mix('js/laravel.app.js') }}"></script>

<script>
    @php($notifications = array('error', 'success', 'warning', 'info'))
    @foreach($notifications as $notification)
        @if(session()->has($notification))
            {{ "toastr." . $notification }}{!! "('" !!}{{session()->get($notification)}}{!! "')" !!}
        @endif
    @endforeach
</script>

@yield('scripts')
</body>
</html>
