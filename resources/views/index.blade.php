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
                    <div class="input-group">
                        <input class="playlistmap-search" class="form-control bg-transparent text-100" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                               placeholder=" " style=""/>
                        <label class="placehoder1">Search for your genre or a similar sounding artist</label>
                        <!--<label>Try &quot;<span class="red">edm</span>&quot; or &quot;<span class="red">the weekend</span>&quot;</label>-->
                        <button onclick="ym(73260880, 'reachGoal', 'homepageserachbtn'); return true;" type="submit" class="input-group-text bg-transparent text-100"><i class="fas fa-magnifying-glass"></i></button>
                        <button class="input-group-text clear-input"><i class="fas fa-circle-xmark"></i></button>
                    </div>
                </form>
            </div>
            <a href="#" class="buttonMobileCenter"><button class="secondary how-it-works"><i class="fas fa-play"></i>See how it works</button></a>
        </div>
        @include('frontend.components.pages.trusted-by', ['position' => 'center'])

        <div class="text-center scroll-down">
            <img class="scroll-down-top me-2" src="{{asset('/images/icons/scroll-down.svg')}}" />
            <img class="scroll-down-bottom me-2" src="{{asset('/images/icons/scroll-down-hover.svg')}}" />
            <span>Scroll Down</span>
        </div>

    </div>
</section>
<section class="homepage-section homepage-section-how-it-works">
    <div class="wrap">
        <h2 class="text-center playlistTitle">This Is Playlisting, Made Easy</h2>
        <div style="margin: 16px 0px !important;">
            <div class="row how-it-works" style="margin: 0px;">

                <div class="single-how-it-works col-md-4 text-center">
                    <div class="row">
                        <div class="col-4 col-md-12" style="margin: auto;">
                            <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                                <img class="normal smallImage" src="{{asset('/images/graphics/find.svg')}}" />
                                <img class="hover" src="{{asset('/images/graphics/find-hover.svg')}}" />
                                <img class="red-line" src="{{asset('/images/graphics/red-line.svg')}}" />
                            </div>
                        </div>
                        <div class="col-8 col-md-12">
                            <h4 class="title2">Discover</h4>
                            <div class="how-it-work-text text2">
                                Identify hundreds of playlists that match your unique genre, subgenre, and sound with our advanced search and filters.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="single-how-it-works col-md-4 text-center">
                    <div class="row">
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

                    <div class="row">
                        <div class="col-4 col-md-12" style="margin:auto;">
                            <div class="image-wrapper d-flex align-items-center justify-content-center m-auto">
                                <img class="normal smallImage" src="{{asset('/images/graphics/pitch.svg')}}" />
                                <img class="hover"  src="{{asset('/images/graphics/pitch-hover.svg')}}" />
                            </div>
                        </div>

                        <div class="col-8 col-md-12">
                            <h4 class="title2">Pitch</h4>
                            <div class="how-it-work-text  text2">
                                Eliminate the stress of writing pitches with our customizable templates. Boost your open rate and get accepted to your ideal playlists.
                            </div>
                        </div>
                    </div>
                    
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

<!-- <section class="homepage-section homepage-section-tabs-section">
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
</section> -->


@include('frontend.components.pages.statistics', ['page' => 'homepage'])
<!-- @include('frontend.components.pages.testimonials', ['page' => 'homepage']) -->
@include('frontend.components.pages.faq', ['page' => 'homepage'])



<!-- <section class="homepage-section homepage-section-get-started">
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
</section> -->
@endsection


<style>


    @media screen and (max-width:767px){
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
            margin-top: 0px !important;
            text-align: left;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 36px;
            color: #FFFFFF;
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
            background: url(http://localhost:8000/images/down_vector.png);
            background-repeat-x: no-repeat;
            background-position: center;
        }

        .backgroundClass{
            background:linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%), url({{asset('images/downBackground.jpg')}}) !important;
        }

        .homepage .homepage-section.homepage-section-hero .wrap .main {
            padding-top: 100px !important;
            padding-right: 10px !important;
            padding-left: 10px !important;
            /* max-width: 740px; */
            /* margin: 0 auto; */
        }

        
    }


    .homepage .homepage-section-how-it-works .single-how-it-works {
            max-width: 100% !important;
        }

    .homepage .homepage-section.homepage-section-hero .trusted-by {
        padding-left: 0px !important;
    }

    .backgroundClass{
        background:linear-gradient(180deg, rgba(18, 18, 18, 0) 1.27%, rgba(18, 18, 18, 0.787848) 53.37%, #121212 73.28%), url({{asset('images/bg/hero.jpg')}})
    }
</style>


