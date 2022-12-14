<!DOCTYPE html>
<html lang="en-US" dir="ltr">

    <head>
        <title>Playlist Map - Spotify Playlist Curators | PlaylistMap.com</title>
        <meta name="description" content="Connect with 10,000+ Spotify playlist curators from around the world to target your ideal future fans and get discovered." />
        @include('frontend.includes.partials.head')
        <link href="vendors/plyr/plyr.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}" />
    </head>

    <body>
        @include('frontend.includes.third-party.gtm_ns')
        <main class="main" id="top">
            <nav class="navbar navbar-standard navbar-expand-lg fixed-top navbar-dark"
                 data-navbar-darken-on-scroll="data-navbar-darken-on-scroll">
                <div class="container" >
                    <a class="navbar-brand" href="{{ route('home') }}">

                        <span class="d-flex align-items-center">
                            <img alt="" class="mr-2" src="images/logo.webp"  width="150">
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
            <section class="py-0 overflow-hidden" id="banner">
                <div class="bg-holder overlay" id="bannertop">
                </div>
                <div class="container">
                    <div class="row flex-center pt-8 pt-lg-10 pb-lg-9 pb-xl-0">
                        <div class="col-md-11 col-lg-8 col-xl-6 pb-7 pb-xl-9 text-center text-xl-left" id="homepagetoptext">
                            <h1 class="text-white font-weight-bold">
                                Get on the right playlists & reach your future fans
                            </h1>
                            <p class="lead text-white font-weight-light">
                                Connect with 20,000+ Spotify playlist curators from around the world to target your ideal audience and get discovered.</p>

                            @php($route = auth()->check() ? route('frontend.search') : route('frontend.search.guest'))
                            <form id="searchform" class="" action="{{ $route }}">
                                <div class="input-group home-search">
                                    <input id="searchbox" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                                           placeholder="Type Music Genres, Artists Names, Playlist Names" style=""/>
                                    <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" type="submit" class="input-group-text bg-transparent text-100"><i class="fa fa-search"></i></button>


                                </div>
                            </form>
                            <div class="search-message">Search keyword should be longer than 2 characters</div>

                            <!-- Button trigger modal -->

                            <div class="pt-xl-5" id="demolinkbox">
                                <a  class="demoVideoBtn" id="demolink"><i id="playicon" class="fas fa-play-circle"></i>See how it works  
                                </a>
                            </div>

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

                        </div>
                        <div class="col-xl-6 align-self-end mt-4 mt-xl-0">
                            <div style="-webkit-transform:translateY(-5rem);-ms-transform:translateY(-5rem);transform:translateY(-5rem)" class="mb-0">
                                <img alt="" class="img-fluid" src="{{ asset('images/frontend/home-hero.gif') }}" />
                            </div>
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
                                            <img alt="" class="w-50"   src="{{ asset('/frontend/img/find.webp') }}" >
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
                                            <img alt="" class="w-50"  src="{{ asset('/frontend/img/unlock.webp') }}" >
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
                                            <img alt="" class="w-50"  src="{{ asset('/frontend/img/Pitch.webp') }}" >
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
                            <img alt="" class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/connect.webp') }}" />
                        </div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
                            <h3 class="hometitles">Connect with the most influential Spotify playlist curators</h3>
                            <p>With our proprietary Spotify playlist mapping, PlaylistMap gives you exclusive access to the largest catalog of Spotify playlist curators, including hard-to-reach contacts you won’t find anywhere else.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-7">
                        <div class="col-md col-lg-5 col-xl-4 pr-lg-6 order-md-2">
                            <img alt="" class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/identify.webp') }}" />
                        </div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
                            <h3>Identify playlists that feature artists like you</h3>
                            <p>PlaylistMap is the only platform that allows you to search for playlists by a specific artist. Identify the playlists with popular artists that are similar to you to increase relevance and reach the right listeners.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-7">
                        <div class="col-md col-lg-5 col-xl-4 pr-lg-6 ">
                            <img alt="" class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/message.webp') }}" />
                        </div>
                        <div class="col-md col-lg-5 col-xl-4 mt-4 mt-md-0" id="toptitleshomepage" >
                            <h3>Pitch smarter and stand out</h3>
                            <p>Our 50+ customizable email templates help you craft a personal, unique message and boost your response rate. Increase your chances of getting on your ideal playlists and receive feedback from popular Spotify playlist curators.</p>
                        </div>
                    </div>
                    <div class="row flex-center mt-7">
                        <div class="col-md col-lg-5 col-xl-4 pl-lg-6 order-md-2">
                            <img alt="" class="img-fluid px-6 px-md-0" src="{{ asset('images/frontend/features/budget.webp') }}" />
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
                                    <img alt="" class="img80" src="{{ asset('images/frontend/benefits/list.webp') }}" >
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
                                    <img alt="" class="img80" src="{{ asset('images/frontend/benefits/robust.webp') }}" >
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
                                    <img alt="" class="img80" src="{{ asset('images/frontend/benefits/fast.webp') }}" >
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
                                                <img alt="" class="rounded-circle  img-fluid" src="{{ asset('images/frontend/features/ronny.webp') }}" >
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

                                                <img alt="" class="rounded-circle  img-fluid" src="{{ asset('/frontend/img/yarden.webp') }}" ><a target="_blank" class="nav-link" href="https://www.instagram.com/yarden_saxophone/" style="color:#000!important">
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
                                            <img alt="" class="rounded-circle  img-fluid" src="{{ asset('/frontend/img/Alusin.webp') }}" >
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

            <!-- FAQs begin ============================-->
            <section class="bg-light">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col">
                            <h1 class="fs-2 fs-sm-4 fs-md-5">Frequently Asked Questions</h1>
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
                                Sign up now (no credit card required) to start getting the streams your music deserve
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
            @include('cookieConsent::index')
        </main>
        <style>
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
    </body>
    <script>
        $(function () {
            $('.demoVideoBtn').click(function () {
                $('#demoVideoModal').modal('show');
            })
        })
    </script>
    <script src="vendors/plyr/plyr.polyfilled.min.js"></script>
</html>
