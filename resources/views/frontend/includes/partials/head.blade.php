<meta charset="utf-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ $title ?? config('app.name') }}</title>
<meta name="description" content="{{ $metaDescription ?? "Connect with 10,000+ Spotify playlist curators from around the world to target your ideal future fans and get discovered."}}" />

<!-- ===============================================-->
<!--    Favicons-->
<!-- ===============================================-->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.webp') }}"/>
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.webp') }}"/>
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.webp') }}"/>
<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicons/favicon.ico') }}"/>
<link rel="manifest" href="{{ asset('images/favicons/manifest.json') }}"/>
<meta name="msapplication-TileImage" content="{{ asset('images/favicons/mstile-150x150.webp') }}"/>
<meta name="theme-color" content="#ffffff"/>


<!-- ===============================================-->
<!--    Open Graph-->
<!-- ===============================================-->

<link rel="alternate" hreflang="en" href="{{ Request::url()}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{$pageTitle ?? "Playlistmap"}}" />
<meta property="og:description" content="{{$pageDescription ?? "Playlistmap"}}" />
<meta property="og:image" content="{{$ogImage ?? asset('images/playlistmap-share.webp')}}" />
<meta property="og:site_name" content="Playlistmap" />
<meta property="og:url" content="{{ Request::url()}}" />

<!-- ===============================================-->
<!--    Fonts-->
<!-- ===============================================-->
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">

<!-- ===============================================-->
<!--    Stylesheets-->
<!-- ===============================================-->

<link rel="stylesheet" type="text/css" href="{{ asset('css/toastr.min.css') }}"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"/>
<script src="https://kit.fontawesome.com/b8506db2c5.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') . "?v=" .  config('constants.assets_version') }}"/>

<script src="{{ asset('vendors/jquery/jquery-3.5.1.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
