@include('frontend.includes.third-party.gtm')

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- ===============================================-->
<!--    Favicons-->
<!-- ===============================================-->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.webp') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.webp') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.webp') }}">
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicons/favicon.ico') }}">
<link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}">
<meta name="msapplication-TileImage" content="{{ asset('images/favicons/mstile-150x150.webp') }}">
<meta name="theme-color" content="#ffffff">

<!-- ===============================================-->
<!--    Stylesheets-->
<!-- ===============================================-->

<link href="{{ asset('frontend/css/theme.css') }}" rel="stylesheet"/>
{{--    <link href="{{ asset('frontend/css/theme-dark.css') }}" rel="stylesheet"/>--}}
<link href="{{ asset('vendors/swiper/swiper-bundle.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/icons.css') }}" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') . "?v=" .  config('constants.assets_version') }}">


@include('frontend.includes.third-party.twik')
@yield('styles')
