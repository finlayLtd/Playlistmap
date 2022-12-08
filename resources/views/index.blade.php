@extends('layouts.frontend-main', ['title' => 'Playlistmap Homepage', 'bodyClass' => 'homepage'])

@section('content')
<section class="homepage-section homepage-section-hero backgroundClass">
    <div class="wrap">
        <div class="main">
            <h1 class="text-center title1">Your Music Deserves To Be Heard</h1>
            <h6 class="text-center text1">Pitch your music to thousands of Spotify playlist curators. Target your ideal audience, increase your streams, and grow your fanbase organically. </h6>
            <div class="w-100 search-wrapper red">
                @php($route = auth()->check() ? route('frontend.search') : route('frontend.search.guest')) 
                <form class="searchform" class="homepage-form-search @if (Auth::guest()) guest @endif" action="{{ $route }}">
                    <div class="input-group position-relative bg-light rounded-pill">
                        <input id="kkk" class="playlistmap-search form-control kkk text-100" style="background-color:transparent" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"/>
                        <span class="text-black placeholder position-absolute">Try "<span class="text-danger">edm</span>" or "<span class="text-danger">weekend</span>"</span>
                        <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" style="z-index:1000" type="submit" class="input-group-text bg-transparent text-100"><i class="fas fa-magnifying-glass"></i></button>
                        <button class="input-group-text clear-input main-search-input" style="z-index:1000" onclick="initialinput()"><i class="fas fa-circle-xmark"></i></button>
                    </div>
                </form>
            </div>
            <a class="buttonMobileCenter"><button class="secondary how-it-works" data-toggle="modal" data-target="#demoVideoModal"><i class="fas fa-play"></i>See how it works</button></a>
        </div>
        @include('frontend.components.pages.trusted-by', ['position' => 'center'])

        <div class="text-center scroll-down">
            <img class="scroll-down-top me-2" src="{{asset('/images/icons/scroll-down.svg')}}" />
            <img class="scroll-down-bottom me-2" src="{{asset('/images/icons/scroll-down-hover.svg')}}" />
            <span>Scroll Down</span>
        </div>

    </div>
</section>
<section class="homepage-section homepage-section-how-it-works marginTopFix">
    <div class="wrap">
        <h2 class="text-center playlistTitle">This Is Playlisting, Made Easy</h2>
        <div style="margin: 16px 0px !important;">
            <div class="row how-it-works" style="margin: 0px;">

                <div class="single-how-it-works col-md-4 text-center">
                    <div class="row chain-works">
                        <div class="col-4 col-md-12" style="margin: auto;">
                            <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                                <img class="normal smallImage" src="{{asset('/images/graphics/find.svg')}}" />
                                <img class="hover" src="{{asset('/images/graphics/find-hover.svg')}}" />
                                <img class="red-line" src="{{asset('/images/graphics/red-line.svg')}}" />
                            </div>
                        </div>
                        <div class="col-8 col-md-12">
                            <h4 class="title2">Find</h4>
                            <div class="how-it-work-text text2">
                                Identify relevant Spotify playlists that match your genre and sound.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="single-how-it-works col-md-4 text-center">
                    <div class="row chain-works">
                        <div class="col-4 col-md-12" style="margin:auto;">
                            <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                                <img class="normal smallImage" src="{{asset('/images/graphics/unlock.svg')}}" />
                                <img class="hover" src="{{asset('/images/graphics/unlock-hover.svg')}}" />
                                <img class="red-line" src="{{asset('/images/graphics/red-line.svg')}}" />
                            </div>
                        </div>

                        <div class="col-8 col-md-12">
                            <h4 class="title2">Unlock</h4>
                            <div class="how-it-work-text  text2">
                                Use your credits to access playlist curators’ names, email addresses, and social media profiles.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="single-how-it-works col-md-4 text-center">

                    <div class="row chain-works">
                        <div class="col-4 col-md-12" style="margin:auto;">
                            <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                                <img class="normal smallImage" src="{{asset('/images/graphics/pitch.svg')}}" />
                                <img class="hover"  src="{{asset('/images/graphics/pitch-hover.svg')}}" />
                            </div>
                        </div>

                        <div class="col-8 col-md-12">
                            <h4 class="title2">Pitch</h4>
                            <div class="how-it-work-text  text2">
                                Use our customizable templates to boost your open rate, create valuable connections, and get accepted to your ideal playlists.
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="how-many-fans row">
            <div class="col-md-5">
                <div class="left">
                    <h4>Your future fans are out there. We’re here to help you reach them.</h4>
                </div>
            </div>
            <div class="col-md-7 marginTop75">
                <div class="right">
                    <img class="music rePosition rePositionLeft" src="{{asset('/images/graphics/music.svg')}}" />
                    <img class="check rePosition rePositionRight" src="{{asset('/images/graphics/check.svg')}}" />
                    <img class="spotify rePosition rePositionRight" src="{{asset('/images/graphics/spotify.svg')}}" />
                    <img class="eye rePositionLeft" src="{{asset('/images/graphics/eye.svg')}}" />
                    <div class="blue-ball rePositionLeft" ></div>
                    <h5>Stop wasting your valuable resources on promotion efforts that get you nowhere. Over 80% of our artists have increased their streams in just 1 month.</h5>
                </div>
            </div>
            
            
        </div>
    </div>
</section>

<section class="homepage-section homepage-section-tabs-section">
    <div class="wrap container">
        <div class="row" style="justify-content: center;">

            <ul class="nav nav-tabs" style="width: auto; text-align: center;">
                <li><a class="active tabTitle" data-toggle="tab" href="#playlisting"><h5>Playlisting</h5></a></li>
                <li><a class="tabTitle" data-toggle="tab" href="#pitch"><h5>Pitch Templates</h5></a></li>
                <li><a class="tabTitle" data-toggle="tab" href="#ai"><h5>AI Recommendations</h5></a></li>
            </ul>
        </div>

        <div class="tab-content">
            <div id="playlisting" class="tab-pane fade in active show">
                <div class="row padding16">
                    <div class="col-md-7 overflow-hidden">
                        <h3 class="mt-4 mb-4 noneDesktop" style="text-align: center;">Playlisting</h3>
                        <img class="eye secondEye" src="{{asset('/images/bg/spotify-bg.webp')}}" />
                    </div>
                    <div class="col-md-5" style="margin:auto;">
                        <span class="noneMobile">1/3</span>
                        <h3 class="mt-4 mb-4 noneMobile">Playlisting</h3>
                        <h6 class="mb-4 sliderText">Quickly identify playlists that match your music to improve your acceptance rate. Uncover contact information for hard-to-get curators, create valuable connections, and send them your tracks.</h6>
                        @guest
                        <a>
                            <button class="tertiary big m-auto rounded-pill" data-toggle="modal" data-target="#register_modal"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
            <div id="pitch" class="tab-pane fade">
                <div class="row padding16">
                    <div class="col-md-7">
                        <h3 class="mt-4 mb-4 noneDesktop" style="text-align: center;">Pitch Templates</h3>
                        <img class="eye secondEye" src="{{asset('/images/bg/spotify-bg.webp')}}" />
                    </div>
                    <div class="col-md-5" style="margin:auto;">
                        <span class="noneMobile">2/3</span>
                        <h3 class="mt-4 mb-4 noneMobile">Pitch Templates</h3>
                        <h6 class="mb-4 sliderText">We get it—you’re a musician, not a marketer.  Use our customizable message templates to speed up your outreach, simplify the pitch process, and boost your success rate. </h6>
                        @guest
                        <a>
                            <button class="tertiary big m-auto rounded-pill" data-toggle="modal" data-target="#register_modal"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
            <div id="ai" class="tab-pane fade">
                <div class="row padding16">
                    <div class="col-md-7">
                        <h3 class="mt-4 mb-4 noneDesktop" style="text-align: center;">AI Recommendations</h3>
                        <img class="eye secondEye" src="{{asset('/images/bg/spotify-bg.webp')}}" />
                    </div>
                    <div class="col-md-5" style="margin:auto;">
                        <span class="noneMobile">3/3</span>
                        <h3 class="mt-4 mb-4 noneMobile">AI Recommendations</h3>
                        <h6 class="mb-4 sliderText"><b>Coming soon. With our new proprietary AI algorithm, we’ll automatically match your tracks with the most relevant playlists to make pitching your music truly effortless. </b></h6>
                        @guest
                        <a>
                            <button class="tertiary big m-auto rounded-pill" data-toggle="modal" data-target="#register_modal"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                        </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="homepage-section homepage-section-discovered-section">
    <div class="wrap">
        <h2 class="text-center timelineBigTitle">Everything You Need To <b>Get Discovered</b></h2>
        <div class="discovered-steps-container position-relative" style="background: url({{asset('images/graphics/big-red-line.svg')}});background-repeat:no-repeat; background-position-x:50%">
            <img class="line-ball line-ball1 noneMobile" src="{{asset('/images/graphics/red-ball.svg')}}" />
            <img class="line-ball line-ball2 noneMobile" src="{{asset('/images/graphics/blue-ball.svg')}}" />
            <img class="line-ball line-ball3 noneMobile" src="{{asset('/images/graphics/red-ball.svg')}}" />
            
            <div class="step step-1 row m-auto">
                <div class="position-relative col-md-6 mobileAlignCenter" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Easy-To-Find Playlists
                        <div class="step-number">01</div>
                    </h3>
                    <h6 class="secondary-color timelineText">Identifying the right playlists is the key to getting discovered. We make it easy to search for and narrow in on relevant playlists that best fit your unique sound.</h6>
                </div>
                <div class="position-relative col-md-6 ps-5">
                    <img class="step-image step1" src="{{asset('/images/graphics/discovered-step1.webp')}}" />
                </div>
            </div>

            <div class="step step-2 row">
                <div class="noneDesktop position-relative col-md-6 mobileAlignCenter m-auto" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Musician-Friendly Interface 
                        <div class="step-number">02</div>
                    </h3>
                    <h6 class="secondary-color timelineText">Our platform is designed to give you a simple, intuitive experience so you can spend less time on promotion and more time making great music.</h6>

                </div>
                <div class="position-relative col-md-6">
                    <img class="step-image step2" src="{{asset('/images/graphics/discovered-step2.webp')}}" />
                </div>
                <div class="noneMobile position-relative col-md-6 mobileAlignCenter m-auto ps-5" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Musician-Friendly Interface 
                        <div class="step-number">02</div>
                    </h3>
                    <h6 class="secondary-color timelineText">Our platform is designed to give you a simple, intuitive experience so you can spend less time on promotion and more time making great music.</h6>

                </div>
            </div>

            <div class="step step-3 row m-auto">
                <div class="position-relative col-md-6 mobileAlignCenter" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Gain Valuable Insights
                        <div class="step-number">03</div>
                    </h3>
                    <h6 class="secondary-color mt-3 timelineText">Get a full profile of each playlist before you pitch to make better decisions. View key metrics like number of followers, last updated, top artists, mood, and various other metrics to find genuine, active playlists. </h6>
                </div>
                <div class="position-relative col-md-6 ps-5">
                    <img class="step-image step3" src="{{asset('/images/graphics/discovered-step3.webp')}}" />
                </div>
            </div>

            <div class="step step-4 row">
                <div class="noneDesktop position-relative col-md-6 mobileAlignCenter m-auto" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Reach Curators Directly
                        <div class="step-number">04</div>
                    </h3>
                    <h6 class="secondary-color timelineText">With PlaylistMap, there’s no mysterious middleman between you and the curators. You have full transparency into and control of your campaigns so you can develop personal connections with playlist gatekeepers.</h6>
                </div>
                <div class="position-relative col-md-6">
                    <img class="step-image step4" src="{{asset('/images/graphics/discovered-step4.webp')}}" />
                </div>
                <div class="noneMobile position-relative col-md-6 mobileAlignCenter m-auto ps-5" style="text-align: left;">
                    <h3 class="position-relative timelineTitle">
                        Reach Curators Directly
                        <div class="step-number">04</div>
                    </h3>
                    <h6 class="secondary-color timelineText">With PlaylistMap, there’s no mysterious middleman between you and the curators. You have full transparency into and control of your campaigns so you can develop personal connections with playlist gatekeepers.</h6>
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
        <div class="row get-started-wrapper padding16">
            <div class="col-md-5">
                <img class="eye secondEye" src="{{asset('/images/bg/get-started-bg.webp')}}" />
            </div>
            <div class="col-md-7 m-auto">
                <h4 class="mt-4 mb-4 centerMobile">Get Started Today!</h4>
                <h5 class="mb-4 sliderText">Want to experience the magic for yourself?<br>
                    Sign up now (no credit card required) to start getting the streams your music deserve</h5>
                @guest
                <a>
                    <button class="tertiary big m-auto rounded-pill" data-toggle="modal" data-target="#register_modal"><i class="fas fa-badge-percent"></i>Start Free Trial</button>
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>
@endsection

@include('frontend.includes.modals.demo_video')

@section('scripts')
<script>
    $(document).ready(function(){
        var reset = eval(<?php echo( isset($reset_modal) && $reset_modal ) ?>);
        if(reset){
            $("#reset_modal").modal('toggle');
        }

        $("#kkk").change(function(){
            if($(this).val()!=""){
                $(this).css('background-color','white');
                $("button.main-search-input").css('display','block');
            } else{
                $(this).css('background-color','transparent');
                $(this).css('background-color','transparent');
                $("button.main-search-input").css('display','none');
            }
        })

        $(".secondary.how-it-works").click(function(){
            $("#vid").attr('src',"{{asset('assets/How-to-use.mp4')}}");
        })
    });

    function initialinput(){
        $('#kkk').val('');
        $('#kkk').css('background-color','transparent');
    }
    
</script>
@endsection

<style>

    .sliderText{
        font-family: 'Lato';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 32px;
        letter-spacing: -0.15px;
        color: #C0C0C0;
    }

    .playlistmap-search{
        z-index: 10;
    }

    input:focus + .placeholder{
        display: none;
    }

    .placeholder{
        left: 25px;
        cursor: auto !important;
        font-size: 20px;
        z-index: 9;
        background: transparent !important;
    }

    .noneDesktop{
        display: none;
    }

    .chain-works{
        padding:0px 34px;
    }

    .title2{
        margin:39.5px auto 24px !important;
    }

    .input-group:has(input.playlistmap-search) button.main-search-input{
        display: none;
    }

    .input-group:has(input.playlistmap-search:focus) button.main-search-input{
        display: block !important;
    }

    @media screen and (max-width:767px){

        h3{
            font-size: 30px !important;
        }

        .homepage .homepage-section-discovered-section .wrap .step.step-2 {
            margin-top: 70px !important;
        }

        .homepage .homepage-section-discovered-section .wrap .discovered-steps-container::after {
            background: none !important;
        }

        .discovered-steps-container{
            background: none !important;
        }

        .timelineBigTitle{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 34px;
            line-height: 44px;
            text-align: center;
            letter-spacing: -0.75px;
        }

        .timelineTitle{
            padding-left: 12px !important;
            padding-right: 12px !important;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 48px;
            line-height: 56px;
            letter-spacing: -0.75px;
        }

        .playlistmap-testimonials .single-testimonial {
            width: 85vw !important;
        }

        .timelineText{
            padding-left: 12px !important;
            padding-right: 12px !important;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #C0C0C0;
        }

        .mobileAlignCenter{
            text-align: center !important;
        }

        .centerMobile{
            text-align: center;
        }

        .homepage .homepage-section-get-started .wrap {
            background: none !important;
        }

        .secondEye{
            border-radius: 20px;
            width: 100%;
        }

        .padding12{
            padding-right: 12px;
            padding-left: 12px;
        }

        .sliderText{
            text-align: center;
            margin-top: 20px;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #C0C0C0;
        }

        .noneDesktop{
            display: block;
        }

        .noneMobile{
            display: none;
        }

        .padding16{
            padding: 16px;
        }

        .main {
            padding-left: 0px !important;
            padding-right: 0px !important;
        }

        .title1{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 48px;
            line-height: 56px;
            letter-spacing: -0.75px;
            color: #FFFFFF;
        }

        .playlistTitle{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 34px;
            line-height: 44px;
            letter-spacing: -0.75px;
            color: #FFFFFF;
        }

        .title2{
            margin: 0px !important;
            text-align: left;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 36px;
            color: #FFFFFF;
        }

        .chain-works{
            padding: 0px !important;
        }

        .text1{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #FFFFFF;
        }

        .text2{
            margin-top: 0px !important;
            text-align: left;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -0.0044em;
            color: #C0C0C0;
        }

        .placehoder1{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #827F7F;
        }

        .rePositionLeft{
            left: 0px !important;
        }

        .rePositionRight{
            right: 0px !important;
        }

        .main{
            padding-left: 16px;
            padding-right: 16px;
        }

        .search-wrapper form.searchform label {
            padding-right: 73px;
            top: -30px !important;
        }

        .buttonMobileCenter{
            display: flex;
            justify-content: center;
        }

        .homepage .homepage-section.homepage-section-hero .trusted-by {
            padding-left: 0px !important;
            margin-top: 64px !important;
        }

        .homepage .homepage-section-how-it-works .single-how-it-works .image-wrapper:before {
            border-radius: 22px !important;
        }

        .smallImage{
            width: 45px !important;
        }

        .homepage .homepage-section-how-it-works .single-how-it-works .image-wrapper {
            height: 67px !important;
            width: 68px !important;
        }

        .single-how-it-works{
            margin-bottom: 24px !important;
            padding-top: 15px !important;
            padding-bottom: 10px !important;
            background: #1B1B1B;
            border-radius: 30px;
        }

        .homepage .homepage-section-how-it-works .wrap {
            padding: 32px 0 !important;
        }

        .homepage .homepage-section-how-it-works .wrap h2 {
            margin-bottom: 24px !important;
        }

        .homepage .homepage-section-how-it-works .single-how-it-works {
            max-width: 100% !important;
        }

        .homepage .homepage-section-how-it-works .single-how-it-works .image-wrapper img.hover {
            width: 55px;
        }

        .red-line{
            display: none;
        }

        .how-it-works{
            background: url("{{asset('images/down_vector.webp')}}");
            background-position: left;
            background-position-x:11.5%;
        }

        .backgroundClass{
            background:linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%), url("{{asset('images/downBackground.webp')}}") !important;
        }

        .homepage .homepage-section.homepage-section-hero .wrap .main {
            padding-top: 100px !important;
            padding-right: 10px !important;
            padding-left: 10px !important;
        }

        .homepage .homepage-section-how-it-works .how-many-fans .left {
            width: auto !important;;
            padding-left: 20px !important;
        }

        .homepage .homepage-section-how-it-works .how-many-fans .left::after {
            width: auto !important;
        }

        .marginTop75{
            margin-top: 75px !important;
            padding-right: 35px !important;
            padding-left: 52px !important;
        }

        .homepage .homepage-section-how-it-works .how-many-fans .right img.music {
            left: 0px !important;
            top: -24px;
        }

        .tabTitle{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -0.0044em;
            color: #827F7F;
        }

        .homepage .homepage-section-tabs-section .wrap ul.nav li h5 {
            padding: 6px 6px !important;
        }

        .homepage .homepage-section-discovered-section .wrap .step-image.step1 {
            max-width: auto;
            width: 100%;
        }

        .homepage .homepage-section-discovered-section .wrap .step-image.step2 {
            max-width: auto;
            width: 100%;
        }

        .homepage .homepage-section-discovered-section .wrap .step-image.step3 {
            max-width: auto;
            width: 100%;
        }

        .homepage .homepage-section-discovered-section .wrap .step-image.step4 {
            max-width: auto;
            width: 100%;
        }

        
    }


    .homepage .homepage-section-how-it-works .single-how-it-works {
            max-width: 100% !important;
        }

    .homepage .homepage-section.homepage-section-hero .trusted-by {
        padding-left: 0px !important;
    }

    .backgroundClass{
        background:linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%), url("{{asset('images/bg/hero.webp')}}")
    }

    .homepage .homepage-section-discovered-section .wrap .step-image.step1 {
        max-width: auto;
        padding-top: 70px !important;
        width: 100%;
    }

</style>




