<div class="d-flex align-items-center" id="navbarStandard">
    <ul class="navbar-nav links d-flex align-items-center">
        <li class="nav-item">
            <a onclick="return true;" style="display:flex; cursor:pointer" class="nav-link {{ Route::is('frontend.search') ? 'active' : '' }}" @if(auth()->check()) href="{{ route('frontend.search') }}" @else data-toggle="modal" data-target="#login_modal" @endif>Browse</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('pages.about') ? 'active' : '' }}" href="/about">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('frontend.profile.plans') ? 'active' : '' }}" href="/pricing">Pricing</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/blog">Blog</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('pages.faq') ? 'active' : '' }}" href="/faq">FAQs</a>
        </li>
    </ul>
</div>
<div class="w-100 search-wrapper">
    @php($route = auth()->check() ? route('frontend.search') : route('frontend.search.guest'))
    <form class="searchform @if(isset($keywords) || ( isset($bodyClass) && $bodyClass=='pricing')) d-none @endif mobile-d-none" class="homepage-form-search @if (Auth::guest()) guest @endif" action="{{ $route }}">

        <div class="input-group">
            <!--<i class="fa fa-search"></i>-->
            <!--<span>Try &quot;<span class="red">edm</span>&quot; or &quot;<span class="red">the weeknd</span>&quot;</span>-->
            <input class="playlistmap-search" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                   placeholder="Try &quot;edm&quot; or &quot;the weeknd&quot;"/>
            <button onclick="return true;" type="submit" class="input-group-text bg-transparent text-100"><i class="fas fa-magnifying-glass"></i></button>
        </div>
    </form>
</div>
<ul class="navbar-nav navbar-nav-icons ml-auto flex-row align-items-center justify-content-end w-100">
    @guest
    <li class="nav-item mr-5 login" style="margin-right: 16px">
        <!-- <a class="nav-link mr-5" href="{{ route('login') }}">
            <button class="outlined"><i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button>
        </a> -->
        <button class="outlined mobile-d-none login-link" data-toggle="modal" data-target="#login_modal">
            <i class="fa-solid fa-arrow-right-to-bracket"></i>Login
        </button>
    </li>
    <li class="nav-item free-trial d-flex">
        <a class="nav-link mobile-d login-link" data-toggle="modal" data-target="#login_modal">
            <button class="tertiary text-white bg-transparent me-2" style="font-size:80%; border:white 1px solid" ><i class="fa-solid fa-arrow-right-to-bracket"></i>Login</button> 
        </a>
        <a class="nav-link register-link">
            <button class="tertiary d-flex text-truncate" data-toggle="modal" data-target="#register_modal" style="font-size:80%" ><i class="fas fa-badge-percent mobile-d-none text-black"></i><span class="mobile-d-none text-black">Start Free Trial</span><span class="mobile-d text-black">Sign Up</span</button> 
        </a>
    </li>
    @endguest

    @auth
    @if(isset(user()->subscription()->name) && user()->subscription()->plan_id == 1)
    <li class="side-menu-upgrade">
        <a class="nav-link upgrade-link" href="/pricing">
            <button class="primary rounded-pill"><i class="fas fa-message-arrow-up"></i>Upgrade<span class="mobile-d-none"> Now</span></button>
        </a>
    </li>
    @endif

    <li class="nav-item dropdown dropdown-user-wrapper">
        <a class="nav-link pr-0 d-flex " id="navbarDropdownUser" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="mr-3 align-self-center name mobile-d-none">{{ user()->name }}</div>
            <div class="avatar avatar-xl">
                @if(user()->avatar_url)
                <img alt="" class="rounded-circle profile-image" src="{{ user()->avatar_url }}"  />
                @else
                <div class="default-avatar-icon">
                    <i class="fas fa-circle-user default-avatar-icon"></i>
                </div>
                @endif
            </div>
            
            <div class="arrow-wrapper align-items-center mobile-d-none">
                <i class="fas fa-chevron-down"></i>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right py-0" aria-labelledby="navbarDropdownUser" style="right:0px; left:auto">
            <div class="rounded-lg py-2 links-wrapper">
                @role('admin')
                <a class="dropdown-item align-items-center" href="{{ route('backend.dashboard') }}">
                    <i class="fas fa-user-crown"></i>Dashboard
                </a>
                @endrole
                <a onclick="return true;" class="dropdown-item align-items-center" href="{{ route('frontend.profile') }}">
                    <i class="me-1 fas fa-user"></i>My Profile
                </a>
                <a onclick="return true;" class="dropdown-item align-items-center" href="{{ route('frontend.myplaylist') }}">
                    <i class="me-1 fa-solid fa-music"></i>My Playlists
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();return true;">
                    <i class="me-1 fas fa-power-off"></i>Logout
                </a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>

    @endauth    

</ul>

<script>
    $(document).ready(function(){
        var verifyEmail = eval(<?php echo(Session::get('verifyEmail'))?>);
        var registerM = eval(<?php echo(Session::get('rgm'))?>);

        if(verifyEmail){
            $("#verify_email").modal("show");
        }
        if(registerM){
            $("#register_modal").modal("show");
        }

        $(".login-link").on('click', function(){
            $("#login_modal").modal("show");
            $("#register_modal").modal("hide");
            $("#forget_modal").modal("hide");
        });
        $(".register-link").on('click', function(){
            $("#register_modal").modal("show");
            $("#login_modal").modal("hide");
            $("#forget_modal").modal("hide");
        });
    });
</script>

<style>
    #btntopregister
    {
        border: 1px solid white;
        border-radius: 12px;
        padding-right: 2%;
        padding-left: 2%;
        height: 26px;
        line-height: 0.5;
        font-weight: 400;
        letter-spacing: 1px;
        width: 160px;
        text-align: center;
        margin-top: 2%;
        background: white;
    }
    #btntopregister > a
    {
        color: #333;
        font-weight: 600;
    }
    #btntopregister:hover a
    {color:#3d3d3d;}

    #searchicon
    {
        font-size: 15px;margin-right:4px;margin-top:2%;
    }

    .upgrade-link{
        margin-right: 1.5rem;
    }

    .arrow-wrapper.mobile-d-none{
        display: flex;
    }
    
    .mobile-menu .side-menu-upgrade{
        display: none;
    }

    @media only screen and (max-width: 600px) {
        #searchicon
        {
            font-size: 15px;margin-right:5px;margin-top:0%;
        }
        .nav-link
        {font-size: 14px;
         font-weight: 400;}
        #btntopregister
        {border:1px solid black}

        header{
            height:40px !important;
        }
    }

    @media screen and (max-width:768px){
        .upgrade-link{
            margin-right:0px;
        }
    }

</style>






