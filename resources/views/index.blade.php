@extends('layouts.frontend-main', ['title' => 'Playlistmap Homepage', 'bodyClass' => 'homepage'])

@section('content')
<section class="homepage-section homepage-section-hero" style="background:linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%), url({{asset('images/bg/hero.jpg')}})">
<!--<section class="homepage-section homepage-section-hero" style="background:{{"linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%)"}}, url({{asset('images/bg/hero.jpg')}}">-->
    <div class="wrap">
        <div class="main">
            <h1 class="text-center">Your Music Deserves To Be Heard</h1>
            <h6 class="text-center">Pitch your music to thousands of Spotify playlist curators. Target your ideal audience, increase your streams, and grow your fanbase organically. </h6>
            <div class="w-100 search-wrapper red">
                @php($route = auth()->check() ? route('frontend.search') : route('frontend.search.guest')) 
                <form class="searchform" class="homepage-form-search @if (Auth::guest()) guest @endif" action="{{ $route }}">
                    <div class="input-group">
                        <input class="playlistmap-search" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                               placeholder=" " style=""/>
                        <label>Search for your genre or a similar sounding artist</label>
                        <!--<label>Try &quot;<span class="red">edm</span>&quot; or &quot;<span class="red">the weekend</span>&quot;</label>-->
                        <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" type="submit" class="input-group-text bg-transparent text-100"><i class="fas fa-magnifying-glass"></i></button>
                        <button class="input-group-text clear-input"><i class="fas fa-circle-xmark"></i></button>
                    </div>
                </form>
            </div>
            <a href="#"><button class="secondary how-it-works"><i class="fas fa-play"></i>See how it works</button></a>
        </div>
        @include('frontend.components.pages.trusted-by', ['position' => false])

        <div class="text-center scroll-down">
            <img class="scroll-down-top me-2" src="{{asset('/images/icons/scroll-down.svg')}}" />
            <img class="scroll-down-bottom me-2" src="{{asset('/images/icons/scroll-down-hover.svg')}}" />
            <span>Scroll Down</span>
        </div>

    </div>
</section>
<section class="homepage-section homepage-section-how-it-works">
    <div class="wrap">
        <h2 class="text-center">This Is Playlisting, Made Easy</h2>
        <div class="row how-it-works d-flex justify-content-between">
            <div class="single-how-it-works col-md-4 text-center">
                <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                    <img class="normal" src="{{asset('/images/graphics/find.svg')}}" />
                    <img class="hover" src="{{asset('/images/graphics/find-hover.svg')}}" />
                    <img class="red-line" src="{{asset('/images/graphics/red-line.svg')}}" />
                </div>
                <h4 class="mt-5">Discover</h4>
                <div class="how-it-work-text mt-4">
                    Identify hundreds of playlists that match your unique genre, subgenre, and sound with our advanced search and filters.
                </div>
            </div>
            <div class="single-how-it-works col-md-4 text-center">
                <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                    <img class="normal" src="{{asset('/images/graphics/unlock.svg')}}" />
                    <img class="hover" src="{{asset('/images/graphics/unlock-hover.svg')}}" />
                    <img class="red-line" src="{{asset('/images/graphics/red-line.svg')}}" />
                </div>
                <h4 class="mt-5">Unlock</h4>
                <div class="how-it-work-text  mt-4">
                    Use your credits to access playlist curators’ names, email addresses, and social media profiles.
                </div>
            </div>
            <div class="single-how-it-works col-md-4 text-center">
                <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                    <img class="normal" src="{{asset('/images/graphics/pitch.svg')}}" />
                    <img class="hover"  src="{{asset('/images/graphics/pitch-hover.svg')}}" />
                </div>
                <h4 class="mt-5">Pitch</h4>
                <div class="how-it-work-text  mt-4">
                    Eliminate the stress of writing pitches with our customizable templates. Boost your open rate and get accepted to your ideal playlists.
                </div>
            </div>
        </div>

        <div class="how-many-fans d-flex justify-content-between">
            <div class="left">
                <h4>Your future fans are out there. We’re here to help you reach them.</h4>
            </div>
            <div class="right">
                <img class="music" src="{{asset('/images/graphics/music.svg')}}" />
                <img class="check" src="{{asset('/images/graphics/check.svg')}}" />
                <img class="spotify" src="{{asset('/images/graphics/spotify.svg')}}" />
                <img class="eye" src="{{asset('/images/graphics/eye.svg')}}" />
                <div class="blue-ball"></div>
                <h5>Stop wasting your valuable resources on promotion efforts that get you nowhere. Over 80% of our artists have increased their streams in just 1 month.</h5>
            </div>
        </div>
    </div>
</section>

<section class="homepage-section homepage-section-tabs-section">
    <div class="wrap">
        <div class="d-flex justify-content-center">

            <ul class="nav nav-tabs justify-content-center">
                <li><a class="active" data-toggle="tab" href="#playlisting"><h5>Playlisting</h5></a></li>
                <li><a data-toggle="tab" href="#pitch"><h5>Pitch Templates</h5></a></li>
                <li><a data-toggle="tab" href="#ai"><h5>AI Recommendations</h5></a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="playlisting" class="tab-pane fade in active show">
                <div class="d-flex">
                    <div>
                        <img class="eye" src="{{asset('/images/bg/spotify-bg.jpg')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-5 content">
                        <span>1/3</span>
                        <h3 class="mt-4 mb-4">Playlisting</h3>
                        <h6 class="mb-4">Quickly identify playlists that match your music to improve your acceptance rate. Uncover contact information for hard-to-get curators, create valuable connections, and send them your tracks.</h6>
                        <a href="#">
                            <button class="tertiary big"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                    </div>
                </div>
            </div>
            <div id="pitch" class="tab-pane fade">
                <div class="d-flex">
                    <div>
                        <img class="eye" src="{{asset('/images/bg/spotify-bg.jpg')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-5 content">
                        <span>2/3</span>
                        <h3 class="mt-4 mb-4">Pitch Templates</h3>
                        <h6 class="mb-4">We get it—you’re a musician, not a marketer.  Use our customizable message templates to speed up your outreach, simplify the pitch process, and boost your success rate. </h6>
                        <a href="#">
                            <button class="tertiary big"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                    </div>
                </div>
            </div>
            <div id="ai" class="tab-pane fade">
                <div class="d-flex">
                    <div>
                        <img class="eye" src="{{asset('/images/bg/spotify-bg.jpg')}}" />
                    </div>
                    <div class="d-flex flex-column justify-content-center ms-5 content">
                        <span>3/3</span>
                        <h3 class="mt-4 mb-4">AI Recommendations</h3>
                        <h6 class="mb-4"><b>Coming soon. With our new proprietary AI algorithm, we’ll automatically match your tracks with the most relevant playlists to make pitching your music truly effortless. </b></h6>
                        <a href="#">
                            <button class="tertiary big"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="homepage-section homepage-section-discovered-section">
    <div class="wrap">
        <h2 class="text-center">Everything You Need To <b>Get Discovered</b></h2>
        <div class="discovered-steps-container position-relative" style="background: url({{asset('images/graphics/big-red-line1.svg')}})">
            <img class="line-ball line-ball1" src="{{asset('/images/graphics/red-ball.svg')}}" />
            <img class="line-ball line-ball2" src="{{asset('/images/graphics/blue-ball.svg')}}" />
            <img class="line-ball line-ball3" src="{{asset('/images/graphics/red-ball.svg')}}" />
            <div class="step step-1 d-flex justify-content-between">
                <div class="position-relative d-flex justify-content-center flex-column">
                    <h3 class="position-relative">
                        Easy-To-Find Playlists
                        <div class="step-number">01</div>
                    </h3>
                    <h6 class="secondary-color">Identifying the right playlists is the key to getting discovered. We make it easy to search for and narrow in on relevant playlists that best fit your unique sound.</h6>
                </div>
                <div class="position-relative">
                    <img class="step-image step1" src="{{asset('/images/graphics/discovered-step1.svg')}}" />
                </div>
            </div>

            <div class="step step-2 d-flex justify-content-between">
                <div class="position-relative">
                    <img class="step-image step2" src="{{asset('/images/graphics/discovered-step2.svg')}}" />
                </div>
                <div class="position-relative d-flex  flex-column content-wrapper">
                    <h3 class="position-relative">
                        Musician-Friendly Interface 
                        <div class="step-number">02</div>
                    </h3>
                    <h6 class="secondary-color">Our platform is designed to give you a simple, intuitive experience so you can spend less time on promotion and more time making great music.</h6>

                </div>
            </div>

            <div class="step step-3 d-flex justify-content-between">
                <div class="position-relative d-flex justify-content-center flex-column">
                    <h3 class="position-relative">
                        Gain Valuable Insights
                        <div class="step-number">03</div>
                    </h3>
                    <h6 class="secondary-color mt-3">Get a full profile of each playlist before you pitch to make better decisions. View key metrics like number of followers, last updated, top artists, mood, and various other metrics to find genuine, active playlists. </h6>
                </div>
                <div class="position-relative">
                    <img class="step-image step3" src="{{asset('/images/graphics/discovered-step3.svg')}}" />
                </div>
            </div>

            <div class="step step-4 d-flex justify-content-between">
                <div class="position-relative">
                    <img class="step-image step4" src="{{asset('/images/graphics/discovered-step4.svg')}}" />
                </div>
                <div class="position-relative d-flex justify-content-center flex-column content-wrapper">
                    <h3 class="position-relative">
                        Reach Curators Directly
                        <div class="step-number">04</div>
                    </h3>
                    <h6 class="secondary-color">With PlaylistMap, there’s no mysterious middleman between you and the curators. You have full transparency into and control of your campaigns so you can develop personal connections with playlist gatekeepers.</h6>
                </div>
            </div>

        </div>
    </div>
</section>


@include('frontend.components.pages.statistics', ['page' => 'homepage'])
@include('frontend.components.pages.testimonials', ['page' => 'homepage'])
@include('frontend.components.pages.faq', ['page' => 'homepage'])



<section class="homepage-section homepage-section-get-started">
    <div class="wrap">
        <div class="d-flex get-started-wrapper">
            <div>
                <img class="eye" src="{{asset('/images/bg/get-started-bg.jpg')}}" />
            </div>
            <div class="d-flex flex-column justify-content-center ms-5 content">
                <h4 class="mt-4 mb-4">Get Started Today!</h4>
                <h5 class="mb-4">Want to experience the magic for yourself?<br>
                    Sign up now (no credit card required) to start getting the streams your music deserve</h5>
                <a href="#">
                    <button class="tertiary big"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                </a>
            </div>
        </div>
    </div>
</section>
@endsection






<?php
/*
  <!DOCTYPE html>
  <html lang="en-US" dir="ltr">

  <head>
  <title>Playlist Map - Spotify Playlist Curators | PlaylistMap.com</title>
  <meta name="description" content="Connect with 20,000+ Spotify playlist curators from around the world to target your ideal future fans and get discovered." />
  @include('frontend.includes.partials.head')
  <script> var homeurl = "{{ url('/')}}";</script>


  <link href="vendors/plyr/plyr.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />





  </head>

  <body class="home">
  @include('frontend.includes.third-party.gtm_ns')
  <main class="main" id="top">
  <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark @if (Auth::guest()) guest @endif"
  data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
  <div class="container" >
  <a class="navbar-brand" href="{{ route('home') }}">

  <span class="d-flex align-items-center">
  <img class="mr-2" src="images/logon.png" alt="" width="150">
  </span>
  </a>
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarStandard"
  aria-controls="navbarStandard" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
  </button>
  @include('frontend.includes.partials.nav-menu')
  </div>
  </nav>

  <!-- Hero begin ============================-->
  <section class="py-0 overflow-hidden backgroundhero"  >
  <div id="bannertop">
  </div>
  <div class="container">
  <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">
  <div class="col-md-11 col-lg-8 col-xl-6 pb-7 pb-xl-9 text-center text-xl-left" id="homepagetoptext">
  <h1 class="text-white font-weight-bold" style="font-weight: 900;">
  Get on the right playlists & reach your future fans
  </h1>
  <p class="lead text-white font-weight-light">
  Connect with 10,000+ Spotify playlist curators from around the world to target your ideal audience and get discovered.</p>

  @php($route = auth()->check() ? route('frontend.search') : route('frontend.search.guest'))
  <form id="searchform" class="homepage-form-search @if (Auth::guest()) guest @endif" action="{{ $route }}">

  <div class="input-group home-search">
  <i class="fa fa-search"></i>
  <input id="searchbox" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
  placeholder="Try &quot;edm&quot; or &quot;the weeknd&quot;" style=""/>
  <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" type="submit" class="input-group-text bg-transparent text-100">Search</button>
  </div>

  <!-- Old search component
  <div class="input-group home-search">
  <input id="searchbox" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
  placeholder="Type Music Genres, Artists Names, Playlist Names" style=""/>
  <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" type="submit" class="input-group-text bg-transparent text-100"><i class="fa fa-search"></i></button>
  </div>

  -->
  </form>
  <div class="search-message">Search keyword should be longer than 2 characters</div>

  <!-- Button trigger modal -->

  <div class="pt-xl-2" id="demolinkbox">
  <a  class="demoVideoBtn" id="demolink"><i id="playicon" class="fas fa-play-circle"></i>See how it works
  </a>
  </div>

  <!-- Talking About Us logos -->
  <div class="pt-xl-6">
  <div class="container"> <p class="lead text-white font-weight-light">
  Trusted By</p>

  <div class="row">
  <div class="col-md-2 col-6 p-3">
  <img class="img-responsive2" src="images/frontend/features/ditto.png">
  </div>
  <div class="col-md-2 col-6 p-3" >
  <img class="img-responsive2" src="images/frontend/features/alteza.png">
  </div>
  <div class="col-md-2 col-6 p-3"  >
  <img class="img-responsive2" src="images/frontend/features/weraveyou.png">
  </div>
  <div class="col-md-2 col-6 p-3" >
  <img class="img-responsive2"  src="images/frontend/features/vini-vici.png">
  </div>
  <div class="col-md-2 col-6 p-3" >
  <img class="img-responsive2"  src="images/frontend/features/nusic.png">
  </div>
  </div>


  </div>
  </div>
  <!-- end Talking About Us Logos -->

  <!-- Modal -->
  <div class="modal fade " id="demoVideoModal" tabindex="-1" aria-labelledby="demoVideoModal" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
  <div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">How to use PlaylistMap</h5>
  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
  </div>
  <div class="modal-body">
  <div class="player rounded-3" data-plyr-provider="youtube" data-plyr-embed-id="unTTNYTu3Nk"> </div>

  </div>
  <div class="modal-footer justify-content-center text-center">
  <a href="{{ route('register') }}" class="btn btn-primary" style="width: 182px;    border-radius: 50px; " class="btn btn-primary btn-block my-4">Start For Free</a>
  </div>
  </div>
  </div>
  </div>

  @auth
  <?php
  $user = Auth::user();
  $dontShow = isset($_COOKIE['aID_popup']);
  $userData = \App\Models\UsersData::where('user_id', $user->id)->get()->first();
  if (!$dontShow && (!$userData || ($userData && !$userData->spotify_artist_id ))) {
  ?>
  <!-- Add artist ID modal -->
  <div class="modal fade " id="addArtistIDModal" tabindex="-1" aria-labelledby="addArtistIDModal" aria-hidden="true">
  <div class="modal-dialog" style="max-width: 500px !important;margin: 0 auto;">
  <div class="modal-content">
  <!--                                        <div class="modal-header">
  <h5 class="modal-title justify-content-center text-center" id="addArtistIDModal">Let's find relevant playlists for you</h5>
  </div>-->
  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
  <!--<img style="width: 100px;" src="{{asset('/images/icons/spotify.png')}}" /> -->
  <div class="modal-body p-4">

  <h4 class="justify-content-center text-center">Let's find relevant playlists for you</h4>


  <form class="mt-4" method="POST" action="{{ route('register') }}" style="max-width: 400px;margin: 0 auto;">
  <!--<h5 class="mt-4">Please enter your artist name on Spotify.</h5>-->
  @csrf
  <input type="hidden" name="spotify-artist-id" value="{{ old('spotify-artist-id') }}"/>
  <input type="hidden" name="spotify-artist-image" value="{{ old('spotify-artist-image') }}"/>
  <div class="row">
  <div id="artist-wrapper" class="mb-3 ui artist">
  <label for="name" class="form-label">{{ __('Please enter your artist name on Spotify:') }}</label>
  <input id="artist-id" type="text" class="form-control @error('name') is-invalid @enderror"
  name="artist-id" value="{{ old('artist-id') }}" autocomplete="artist-id" autofocus>
  <x-error field="artist-id"></x-error>
  </div>
  <div class="artist-image-wrapper col-md-6">
  <img id="artist-image" src="https://i.scdn.co/image/ab6761610000e5ebefeb80bd23b299d413c04d8f" />
  </div>
  </div>

  <div class="row justify-content-center text-center" style="max-width: 270px;margin: 0 auto">
  <button class="btn btn-primary mt-2" id="update-artist-id">Update Account</button>
  <a id="dont-show-artist-modal" class="mt-3" href="#" style="text-decoration:underline;">Don't Show Again</a>
  </div>
  </form>

  </div>
  <!--                                        <div class="modal-footer justify-content-center text-center">
  <a href="{{ route('register') }}" class="btn btn-primary" style="width: 182px;    border-radius: 50px; " class="btn btn-primary btn-block my-4">Start For Free</a>
  </div>-->
  </div>
  </div>
  </div>
  <?php
  }
  ?>
  @endauth



  </div>

  </div>
  </div>
  </section>
  <!-- Hero close ============================-->

  <!-- Features begin ============================-->
  <section>
  <div class="container">



  <!-- 3 how to begin ============================-->
  <section class="text-center" style="padding-top: 0rem;
  padding-bottom: 3rem;">
  <div class="container">

  <div class="row">
  <div class="col-lg-4">
  <div>
  <div class="card-span-img">
  <img class="w-50"   src="{{ asset('/frontend/img/find.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h3 class="mb-2 font-weight-bold text-lg">1. Find the right playlists</h3>
  <p>Identify relevant Spotify playlists that match your genre and sound.</p>
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div >
  <div class="card-span-img">
  <img class="w-50"  src="{{ asset('/frontend/img/unlock.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h3 class="mb-2 font-weight-bold text-lg">2. Unlock contact information</h3>
  <p>Use your credits to access playlist curators’ names, email addresses, and social media profiles.
  </p>
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div >
  <div class="card-span-img">
  <img class="w-50"  src="{{ asset('/frontend/img/Pitch.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h3 class="mb-2 font-weight-bold text-lg">3. Pitch your music</h3>
  <p>Use our customizable templates to boost your open rate, create valuable connections, and get accepted to your ideal playlists.</p>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- 3 how to begin close ============================-->






  <div class="row justify-content-center text-center">




  <div class="col-lg-8 col-xl-7 col-xxl-6">
  <h1 class="fs-2 fs-sm-4 fs-md-5">{{ config('app.name') }} is reinventing how artists get discovered.</h1>
  <p class="lead">Reach the most relevant Spotify playlist curators, craft the perfect pitch, and share your music with the world.</p>
  </div>
  </div>
  <div class="row flex-center mt-8">
  <div class="col-md col-lg-5 col-xl-4 pl-lg-6">
  <img class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/connect.png') }}" alt=""/>
  </div>
  <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
  <h3 class="hometitles">Connect with the most influential Spotify playlist curators</h3>
  <p>With our proprietary Spotify playlist mapping, PlaylistMap gives you exclusive access to the largest catalog of Spotify playlist curators, including hard-to-reach contacts you won’t find anywhere else.</p>
  </div>
  </div>
  <div class="row flex-center mt-7">
  <div class="col-md col-lg-5 col-xl-4 pr-lg-6 order-md-2">
  <img class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/identify.png') }}" alt=""/>
  </div>
  <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
  <h3>Identify playlists that feature artists like you</h3>
  <p>PlaylistMap is the only platform that allows you to search for playlists by a specific artist. Identify the playlists with popular artists that are similar to you to increase relevance and reach the right listeners.</p>
  </div>
  </div>
  <div class="row flex-center mt-7">
  <div class="col-md col-lg-5 col-xl-4 pr-lg-6 ">
  <img class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/message.png') }}" alt=""/>
  </div>
  <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
  <h3>Pitch smarter and stand out</h3>
  <p>Our 50+ customizable email templates help you craft a personal, unique message and boost your response rate. Increase your chances of getting on your ideal playlists and receive feedback from popular Spotify playlist curators.</p>
  </div>
  </div>
  <div class="row flex-center mt-7">
  <div class="col-md col-lg-5 col-xl-4 pl-lg-6 order-md-2">
  <img class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/budget.png') }}" alt=""/>
  </div>
  <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
  <h3>Budget-friendly, zero commitment</h3>
  <p>No middle man, no campaign budgets, and no surprises. Get full transparency and direct control of your correspondence with the people behind the best playlists.</p>
  </div>
  </div>
  </div>
  </section>
  <!-- Features close ============================-->


  <!-- Benefits begin ============================-->
  <section class="bg-light text-center">
  <div class="container">
  <div class="row">
  <div class="col">
  <h1 class="fs-2 fs-sm-4 fs-md-5">Why go premium?</h1>
  <p class="lead">Things you will get right out of the box with {{ config('app.name') }}.</p>
  </div>
  </div>
  <div class="row mt-6">
  <div class="col-lg-4">
  <div class="card card-span h-100">
  <div class="card-span-img">
  <img class="img80" src="{{ asset('images/frontend/benefits/list.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h5 class="mb-2">Unrivaled access</h5>
  <p>Our database of Spotify playlist curators exceeds 20,000 making it the largest in the world.</p>
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div class="card card-span h-100">
  <div class="card-span-img">
  <img class="img80" src="{{ asset('images/frontend/benefits/robust.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h5 class="mb-2">Robust filters</h5>
  <p>Set search criteria so you only find playlist curators that are highly relevant to you..</p>
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div class="card card-span h-100">
  <div class="card-span-img">
  <img class="img80" src="{{ asset('images/frontend/benefits/fast.png') }}" alt="">
  </div>
  <div class="card-body pt-6 pb-4">
  <h5 class="mb-2">Fast results</h5>
  <p>Leverage our database of curators and crafted email templates to grow your audience and get discovered.</p>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- Benefits close ============================-->

  <!-- Testimonials begin ============================-->
  <section class="bg-200 text-center">
  <div class="container">
  <div class="row justify-content-center">
  <div class="col-12">
  <div class="swiper-container theme-slider"
  data-swiper='{"autoplay":true,"spaceBetween":5,"loop":true,"loopedSlides":5,"slideToClickedSlide":true}'>
  <div class="swiper-wrapper">


  <div class="swiper-slide">
  <div class="px-5 px-sm-6">
  <div class="d-flex mb-3">
  <img class="rounded-circle  img-fluid" src="{{ asset('images/frontend/features/eliav.jpg') }}" alt="">
  <div class="ml-3 align-self-center text-left lh-1 text-black">
  <p class="mb-1">X-Hood21</p>
  <p class="mb-1">Music producer</p>
  </div>

  </div>
  <p class="fs-1 font-italic text-dark text-left">
  My experience with PlaylistMap has change everything I thought I knew about playlisting. Thanks to PlaylistMap,  I was able to save tons of time and money, create strong and fruitful connections with curators, and gain the ability to reach out to many more in the click of a button!
  </p>
  <p class="fs-0 text-600 text-left"><i class="fal fa-clock mr-1"></i> 15 July, 2021</p>
  </div>
  </div>


  <div class="swiper-slide">
  <div class="px-5 px-sm-6">
  <div class="d-flex mb-3">
  <img class="rounded-circle  img-fluid" src="{{ asset('images/frontend/features/ronny.jpg') }}" alt="">
  <div class="ml-3 align-self-center text-left lh-1 text-black">
  <p class="mb-1">Ronny</p>
  <p class="mb-1">Hip Hop artists</p>
  </div>

  </div>
  <p class="fs-1 font-italic text-dark text-left">
  This tool is f**king amazing! Saved so much time and effort for me to search and find good playlists for my genre and most importantly, it gives you the contact info for every playlist curator. I mean, this is crazy man, I could search for hours for a good playlist and sometimes it took even longer to find their contact info, but now it's all in front of you!
  </p>
  <p class="fs-0 text-600 text-left"><i class="fal fa-clock mr-1"></i> 02 February, 2021</p>
  </div>
  </div>


  <div class="swiper-slide">
  <div class="px-5 px-sm-6">
  <div class="d-flex mb-3">

  <img class="rounded-circle  img-fluid" src="{{ asset('/frontend/img/yarden.png') }}" alt=""><a target="_blank" class="nav-link" href="https://www.instagram.com/yarden_saxophone/" style="color:#000!important">
  <div class="ml-3 align-self-center text-left lh-1 text-black">
  <p class="mb-1">Yarden Saxophone</p>
  <p class="mb-1">Artist</p>
  </a>
  </div>


  </div>
  <p class="fs-1 font-italic text-dark text-left">
  Playlistmap is a game changer for both signed and independent musicians. It's a must-have tool for every artist who wants to get their music to as many listeners as possible. It saved me so much valuable time, and put me in touch with so many playlist curators. For me it's an essential part of every new release campaign.
  </p>
  <p class="fs-0 text-600 text-left"><i class="fal fa-clock mr-1"></i> 14 February, 2021</p>
  </div>
  </div>


  <div class="swiper-slide">
  <div class="px-5 px-sm-6">
  <div class="d-flex mb-3">
  <img class="rounded-circle  img-fluid" src="{{ asset('/frontend/img/Alusin.png') }}" alt="">
  <div class="ml-3 align-self-center text-left lh-1 text-black">
  <p class="mb-1">Alusin</p>
  <p class="mb-1">Music Producer</p>
  </div>

  </div>
  <p class="fs-1 font-italic text-dark text-left">
  With PlaylistMap, one of the biggest problems we face as creators releasing music has been solved. Now I can use the site’s ready-made templates to easily reach any playlist I want instead of having to deal with the endless rewriting of emails. I definitely recommend this platform.
  </p>
  <p class="fs-0 text-600 text-left"><i class="fal fa-clock mr-1"></i> 18 February, 2021</p>
  </div>
  </div>

  </div>
  <div class="swiper-nav">
  <div class="swiper-button-next swiper-button-white"></div>
  <div class="swiper-button-prev swiper-button-white"></div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- Testimonials close ============================-->


  <!-- Tiktokers begin ============================-->
  <section class="bg-light text-center">
  <div class="container">
  <div class="row">
  <div class="col">
  <h1 class="fs-2 fs-sm-4 fs-md-5">Look who's talking about us on TikTok</h1>
  <p class="lead">Check out these PlaylistMap tips, tricks, and success stories from top music influencers.</p>
  </div>
  </div>
  <div class="row mt-6">
  <div class="col-lg-4">
  <div class="card card-span h-100">
  <div class="card-body pt-6 pb-4">
  <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@rickyreilly3/video/6936666579467848965" data-video-id="6936666579467848965" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="@rickyreilly3" href="https://www.tiktok.com/@rickyreilly3">@rickyreilly3</a> <p>Playlist pitching tool! <a title="spotify" target="_blank" href="https://www.tiktok.com/tag/spotify">#spotify</a> <a title="spotifyplaylists" target="_blank" href="https://www.tiktok.com/tag/spotifyplaylists">#spotifyplaylists</a> <a title="learnontiktok" target="_blank" href="https://www.tiktok.com/tag/learnontiktok">#learnontiktok</a> <a title="musicproductiontips" target="_blank" href="https://www.tiktok.com/tag/musicproductiontips">#musicproductiontips</a> <a title="songwritersoftiktok" target="_blank" href="https://www.tiktok.com/tag/songwritersoftiktok">#songwritersoftiktok</a> <a title="playlistmap" target="_blank" href="https://www.tiktok.com/tag/playlistmap">#playlistmap</a></p> <a target="_blank" title="♬ main title ~ star wars lofi - Closed on Sunday" href="https://www.tiktok.com/music/main-title-star-wars-lofi-6815793470846797826">♬ main title ~ star wars lofi - Closed on Sunday</a> </section> </blockquote>
  <script src="https://www.tiktok.com/embed.js"></script>
  <!-- <script async src="https://www.tiktok.com/embed.js"></script> -->
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div class="card card-span h-100">

  <div class="card-body pt-6 pb-4">
  <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@bigbossmusicmastering/video/6950067995804716289" data-video-id="6950067995804716289" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="@bigbossmusicmastering" href="https://www.tiktok.com/@bigbossmusicmastering">@bigbossmusicmastering</a> <p>A game changer for Pitching to Playlists. <a title="musicpromo" target="_blank" href="https://www.tiktok.com/tag/musicpromo">#musicpromo</a> <a title="producertips" target="_blank" href="https://www.tiktok.com/tag/producertips">#producertips</a>  <a title="spotifyplaylisthelp" target="_blank" href="https://www.tiktok.com/tag/spotifyplaylisthelp">#spotifyplaylisthelp</a> <a title="spotifytips" target="_blank" href="https://www.tiktok.com/tag/spotifytips">#spotifytips</a> <a title="submithub" target="_blank" href="https://www.tiktok.com/tag/submithub">#submithub</a>  <a title="musicpromotion" target="_blank" href="https://www.tiktok.com/tag/musicpromotion">#musicpromotion</a> <a title="playlistmap" target="_blank" href="https://www.tiktok.com/tag/playlistmap">#playlistmap</a></p> <a target="_blank" title="♬ Campus - Vampire Weekend" href="https://www.tiktok.com/music/Campus-6751217494146418689">♬ Campus - Vampire Weekend</a> </section> </blockquote>
  <!--                                    <script src="https://www.tiktok.com/embed.js"></script>-->
  </div>
  </div>
  </div>
  <div class="col-lg-4 mt-6 mt-lg-0">
  <div class="card card-span h-100">
  <div class="card-body pt-6 pb-4">
  <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@britneyditoccomusic/video/6936352605715074310" data-video-id="6936352605715074310" style="max-width: 605px;min-width: 325px;" > <section> <a target="_blank" title="@britneyditoccomusic" href="https://www.tiktok.com/@britneyditoccomusic">@britneyditoccomusic</a> <p>I’ll keep you guys posted on if I get selected for any of these playlists! :) <a title="playlists" target="_blank" href="https://www.tiktok.com/tag/playlists">#playlists</a> <a title="indieartists" target="_blank" href="https://www.tiktok.com/tag/indieartists">#indieartists</a> <a title="songwriting" target="_blank" href="https://www.tiktok.com/tag/songwriting">#songwriting</a> <a title="bandkids" target="_blank" href="https://www.tiktok.com/tag/bandkids">#bandkids</a> <a title="indierock" target="_blank" href="https://www.tiktok.com/tag/indierock">#indierock</a></p> <a target="_blank" title="♬ Up - Cardi B" href="https://www.tiktok.com/music/Up-6925658290315593729">♬ Up - Cardi B</a> </section> </blockquote>
  <!--<script async src="https://www.tiktok.com/embed.js"></script>-->
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- TikTokers close ============================-->

  <!-- FAQs begin ============================-->
  <section class="bg-light">
  <div class="container">
  <div class="row mb-4">
  <div class="col">
  <h1 class="fs-2 fs-sm-4 fs-md-5">Frequently asked questions</h1>
  </div>
  </div>
  <div class="row ">
  <div class="col-12">
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">How often do you update the catalog of playlist curators?
  <span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">We automatically update our catalog daily. Every time we update it, we add more and more playlists and make sure the information for our current ones are up-to-date. With more than 20,000 playlists already on our catalog, PlaylistMap has more curator contacts than any of our competitors.</p>
  <hr class="my-3">
  </div>
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">What is a credit?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">A credit is the currency you use to unlock a Spotify playlist curator’s contact information on our platform. One credit gets you one unlock. Each of our plans offers a different amount of credits. With more credits, you’ll have more opportunities to get in touch with relevant curators, introduce them to your music, and get added to their playlists.</p>
  <hr class="my-3">
  </div>
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">What if I don’t use up all of my credits by the end of the month?
  <span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">If you don’t use all of your credits, then you’re not pitching enough! For the best results, use all of the credits you pay for — this will increase your chances of getting included on your ideal playlists. At the end of each month, any remaining credits will roll over to the next month. If you decide to cancel your subscription, you can use your remaining credits until the end of the last paid month.</p>
  <hr class="my-3">
  </div>
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">What’s my commitment after signing up?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">There is no commitment. If you’re not satisfied with the platform, you can cancel at any time, and you will not be charged in the following month. </p>
  <hr class="my-3">
  </div>
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">What happens if I use a credit but the playlist curator contact information is no good?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">We do our best to verify every Spotify playlist curator’s contact information, but in the event that it’s wrong, let us know by clicking the “report” button on the “My Unlocks” section on your profile, and we will check it out. If the contact information is fake or incorrect, we will refund your credit. </p>
  <hr class="my-3">
  </div>
  <div>
  <h6>
  <a class="hover-text-decoration-none fs-1" href="javascript:void(0)">What if a Spotify playlist curator asks for money?<span class="fas fa-caret-right" data-fa-transform="right-7"></span></a>
  </h6>
  <p class="fs--1 mb-0">Never pay a curator in exchange for getting added to their playlist. We know it’s tempting, but trust us, don’t do it. If you do, you’ll be in violation of <a href="https://www.spotify.com/us/legal/end-user-agreement/#9-user-guidelines" target="_blank">Spotify’s policies</a> , which could lead you to getting kicked off their platform. Or, the playlist might get taken down. Technically, Spotify playlist curators are allowed to accept payments for listening to songs, as long as they don’t “sell” spots on their playlists. </p>
  <hr class="my-3">
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- FAQs close ============================-->

  <!-- CTA begin ============================-->
  <section>
  <div class="bg-holder overlay" id="bottomhero">
  </div>
  <div class="container">
  <div class="row justify-content-center text-center">
  <div class="col-lg-12">
  <h2 class="text-white">Get Started Today!</h2>
  <p class="fs-1 text-white">
  Want to experience the magic for yourself? <br>
  Sign up now (no credit card required) to start getting heard
  </p>
  <a href="{{ route('register') }}" class="btn btn-outline-light border-2 rounded-pill btn-lg mt-4 fs-0 py-2" type="button">
  Start For Free
  </a>
  </div>
  </div>
  </div>
  </section>
  <!-- CTA close ============================-->


  <!-- Footer Menu begin ============================-->
  <section class="bg-dark pt-8 pb-4">

  <div class="container">
  <div class="position-absolute btn-back-to-top bg-dark">
  <a class="text-600" href="#banner" data-offset-top="0" data-scroll-to="#banner">
  <span class="fas fa-chevron-up" data-fa-transform="rotate-45"></span>
  </a>
  </div>
  <div class="row">
  <div class="col-lg-4">
  <h5 class="text-uppercase text-white opacity-85 mb-3">{{ config('app.name') }}</h5>
  </div>
  <div class="col-lg-8">
  <ul class="nav">
  <li class="mx-4"><a class="link-600" href="{{ route('pages.about') }}">About</a></li>
  <li class="mx-4"><a class="link-600" href="{{ route('pages.terms') }}">Terms Of Service</a></li>
  <li class="mx-4"><a class="link-600" href="{{ route('pages.privacy') }}">Privacy Policy</a></li>
  <li class="mx-4"><a class="link-600" href="{{ route('pages.faq') }}">FAQs</a></li>
  <li class="mx-4"><a class="link-600" href="mailto:support@playlistmap.com">Contact</a></li>
  <li class="mx-4"><a class="link-600" target="_blank" href="https://playlistmap.com/blog">Blog</a></li>
  </ul>
  </div>
  </div>
  </div>
  <!-- end of .container-->

  </section>
  <!-- Footer Menu close ============================-->


  <!-- Footer begin ============================-->
  <section class="py-0 bg-dark">
  <div>
  <hr class="my-0 border-600 opacity-25"/>
  <div class="container py-3">
  <div class="row justify-content-between fs--1">
  <div class="col-12 col-sm-auto text-center">
  <p class="mb-0 text-600 opacity-85">
  {{ now()->format('Y') }} &copy; <a class="text-white opacity-85" href="{{ route('home') }}">{{ config('app.name') }}</a>
  </p>
  </div>
  <div class="col-12 col-sm-auto text-center">

  <div class="icon-group">
  <a class="mx-2 ml-0 d-inline-block text-white" href="https://www.facebook.com/playlistmap/">
  <span class="fab fa-facebook-f"></span>
  </a>
  <a class="mx-2 d-inline-block text-white" href="https://www.instagram.com/playlistmap/">
  <span class="fab fa-instagram"></span>
  </a>
  </div>
  </div>
  </div>
  </div>
  </div>
  </section>
  <!-- Footer close ============================-->


  <!-- @include('cookieConsent::index') cookie consent removed 18/07/2021 -->
  </main>
  <style>
  .img-responsive2{
  width: 100%; }
  .backgroundhero
  {
  background-image: url('images/frontend/features/bg-hero.jpg');
  background-repeat: no-repeat;
  background-position: center;
  -o-background-size:cover;
  -moz-background-size:cover;
  -webkit-background-size:cover;
  background-size: cover;כ
  }
  .modal {
  top: 20% !important;
  }
  @media (min-width: 576px)
  {
  .modal-dialog {
  max-width: 681px !important;
  }
  }

  .plyr__control--overlaid {
  background: #333 !important;}


  #demolink
  {
  color: white; cursor: pointer;
  }
  #playicon
  {
  font-size: 26px;
  margin-right: 1%;
  }

  @media (max-width: 767px)
  {
  .img-responsive2
  {
  width: 70%;
  }
  #demolinkbox
  {
  margin-top: 8%;
  font-size: 14px;
  font-weight: 300;
  }
  #playicon
  {
  font-size: 16px;
  margin-right: 1%;
  }
  }


  </style>

  @include('frontend.includes.partials.scripts')
  <script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
  integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
  crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />

  </body>
  <script>
  $(function () {
  $('.demoVideoBtn').click(function () {
  $('#demoVideoModal').modal('show');
  });
  $('#addArtistIDModal').modal('show');

  $("#addArtistIDModal").on('shown.bs.modal', function (e) {
  //console.log("I want this to appear after the modal has opened!");
  addArtistAutoCompleteEvents();

  });

  });
  </script>
  <script src="vendors/plyr/plyr.polyfilled.min.js"></script>
  </html>
 */?>