<!DOCTYPE html>
<html lang="en-US" dir="ltr">

    <head>
        @include('frontend.includes.partials.head')
        @yield('styles')
    </head>

    <body class="{{$bodyClass ?? '' }}" style="background:#121212">

        @include('frontend.includes.third-party.gtm_ns')

        @include('frontend.includes.partials.navbar')
        
        <main class="main" id="top">
            <div class="content">
                @yield('content')
            </div>
        </main>
        
        @include('frontend.includes.partials.footer')
        @include('frontend.includes.partials.scripts')
        @yield('footer-scripts')
    </body>

</html>
