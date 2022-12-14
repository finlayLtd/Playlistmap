<header class="@auth @if(isset(user()->subscription()->name) && user()->subscription()->name !== "primary") upgrade @endif @endauth">
    <div class="m-auto" style="max-width:1440px">
        <div class="mobile-nav-button-close">
            <i class="fa fa-xmark"></i>
        </div>
        <nav class="navbar navbar-light navbar-glass navbar-top d-flex align-items-center navbar-expand-lg flex-nowrap">
            <div class="mobile-nav-button">
                <i class="fa fa-bars"></i>
            </div>
    
    
    
            <div class="mr-5">
                <a class="navbar-brand d-flex align-items-center homepage-link" href="{{ route('home') }}">
                    <div class="">
                        <img alt="" class="mr-2" src="{{ asset('images/logo-w.webp') }}"  width="150" />
                    </div>
                </a>
            </div>
            @include('frontend.includes.partials.nav-menu')
            @include('frontend.includes.modals.login')
            @include('frontend.includes.modals.register')
            @include('frontend.includes.modals.forget')
            @include('frontend.includes.modals.verify-email')
            @include('frontend.includes.modals.loader')
            @include('frontend.includes.modals.reset-password')
        </nav>
    </div>
</header>