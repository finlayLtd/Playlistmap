<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
    <title>{{ config('app.name') }}</title>
    @include('frontend.includes.partials.head')
    @yield('scripts')
</head>

<body>

<main class="main" id="top">
    <div class="container-fluid">
        <div class="content">
            @yield('content')
        </div>
    </div>
</main>

@include('frontend.includes.partials.scripts')

</body>

</html>
