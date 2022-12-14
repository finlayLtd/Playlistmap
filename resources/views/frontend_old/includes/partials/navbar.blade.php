


<nav class="navbar navbar-light navbar-glass navbar-top navbar-expand-lg">
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarStandard"
            aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand mr-1 mr-sm-3" href="{{ route('home') }}">
        <div class="d-flex align-items-center">
            <img alt="" class="mr-2" src="{{ asset('images/logon_inverse.webp') }}"  width="90" />
        </div>
    </a>
    @include('frontend.includes.partials.nav-menu')
</nav>
