<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <title>{{ config('app.name') }}</title>
    @include('frontend.includes.partials.head')
</head>

<body>
@include('frontend.includes.third-party.gtm_ns')


<div id="loader" class="vh-100 justify-content-center align-items-center" style="display: none">
    <div class="spinner-grow" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>
<main class="main" id="top">
    <div class="container">
        <div class="content">
            @include('frontend.includes.partials.navbar')
            @yield('content')
            @include('frontend.includes.partials.footer')
            <!-- @include('cookieConsent::index') -->
        </div>
    </div>
</main>
<script> var homeurl = "{{ url('/')}}";</script>
@include('frontend.includes.partials.scripts')
</body>

</html>
