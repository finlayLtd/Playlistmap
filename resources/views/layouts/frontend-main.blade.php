<!DOCTYPE html>
<html lang="en-US" dir="ltr">

    <head>
        @include('frontend.includes.partials.head')
        @yield('head-scripts')
        
        <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
        <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

    </head>

    <body class="{{$bodyClass ?? "" }}" style="background:#121212">
        @include('frontend.includes.third-party.gtm_ns')

        @include('frontend.includes.partials.navbar')

        <!--<div id="loader" class="vh-100 justify-content-center align-items-center" style="display: none">
            <div class="spinner-grow" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>-->
        
        
        <main class="main" id="top">
            <!--<div class="container">-->
                <div class="content">
                    @yield('content')
                </div>
            <!--</div>-->
        </main>
        
        @include('frontend.includes.partials.footer')
        <script> var homeurl = "{{ url('/')}}";</script>
        @include('frontend.includes.partials.scripts')
        @yield('footer-scripts')
    </body>

</html>
