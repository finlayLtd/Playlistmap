@extends('layouts.frontend-main', ['title' => 'Playlistmap About', 'bodyClass' => 'about'])
@section('content')
<section class="about-section about-section-hero" style="background:linear-gradient(180.39deg, rgba(18, 18, 18, 0) -5.24%, rgba(18, 18, 18, 0.787848) 75.74%, #121212 94.1%), url({{asset('images/bg/about-hero.jpg')}})">
    <div class="wrap">
        <div class="main">

            <img class="logo d-block m-auto" src="{{ asset('images/logo-w.png') }}" alt="" width="150" />

            <div class="about-headline text-center mt-5">We’re Revolutionizing Music Promotion For Artists And Curators</div>
            @include('frontend.components.pages.trusted-by', ['position' => 'center'])
        </div>
        <div class="text-center scroll-down">
            <img class="scroll-down-top me-2" src="{{asset('/images/icons/scroll-down.svg')}}" />
            <img class="scroll-down-bottom me-2" src="{{asset('/images/icons/scroll-down-hover.svg')}}" />
            <span>Scroll Down</span>
        </div>
    </div>
</section>

<section class="about-section about-section-why-playlistmap">
    <div class="wrap">
        <div class="position-relative inner-wrapper">
            <div class="why-we-created-content pt-4">
                <h1>
                    <span class="red">Why We Created</span><br>
                    PlaylistMap
                </h1>
                <h5 class="secondary-color">
                    Artists are struggling to promote their music, reach the right listeners, and get discovered. Curators are struggling to grow their playlists and gain more followers without getting spammed by irrelevant song submissions.
                    <br>We built PlaylistMap to solve both problems.
                </h5>

            </div>
            <div class="guitar-wrapper">
                <img class="scroll-down-top me-2" src="{{asset('/images/bg/guitar.jpg')}}" />
                <img class="guitar-music"src="{{asset('/images/graphics/guitar-graphic.svg')}}" /> 
            </div>
        </div>

    </div> 
</section>

<section class="about-section about-section-what-is-playlistmap">
    <div class="wrap">
        <div class="what-is-playlistmap mt-5">
            <h3>What is PlaylistMap? </h3>
            <h5 class="secondary-color">
                PlaylistMap is the first-ever Artist Discovery Platform. Powered by our proprietary AI algorithm, we use advanced technology and data-driven insights to simplify discovery for artists, labels, and curators. 
                <br><br>
                With PlaylistMap, independent artists and labels can pinpoint hyper-relevant playlists and pitch their songs directly to curators. Curators gain detailed insights on their listeners and a stream of song submissions that suit their playlists. 
            </h5>
        </div>

        <div class="d-flex justify-content-between our-mission-wrapper">
            <div class="mt-5">
                <h3 class="mt-5">Our Mission
                    <img class="our-mission-graphic"src="{{asset('/images/graphics/mission-graphic.svg')}}" /> 
                </h3>
                <h6 class="mt-3 secondary-color">
                    We empower artists to own their music careers and succeed in the digital streaming world, without needing to rely on labels or expensive marketing campaigns.
                    <br><br>
                    At the same time, we’re improving curators’ experience by helping them reduce irrelevant pitches and providing key data on their playlists so they can increase their followings.
                </h6>
            </div>
            <div>
                <img class="our-mission-graphic"src="{{asset('/images/bg/curators.png')}}" /> 
            </div>
        </div>
    </div>
</section>

@include('frontend.components.pages.statistics', ['page' => 'about'])


<section class="about-section about-section-team">
    <div class="wrap">
        <h3 class="text-center">Our Team</h3>
        <div class="d-flex justify-content-around mt-5">
            <div class="single-member position-relative">
                <div class="content-wrapper position-relative">
                    <img class="our-mission-graphic"src="{{asset('/images/icons/team/shahar.png')}}" /> 
                    <div class="quote">
                        <div>
                            <i class="fa-light fa-quote-left"></i>
                        </div>
                        <div class="quote-text secondary-color">
                            Fitness addict with a mission of integrating life with art & culture.
                        </div>
                    </div>
                </div>
                <div class="team-member-details">
                    <i class="fa-solid fa-message-lines"></i>
                    <h5 class="name">Shahar Shmueli</h5>
                    <div class="position secondary-color">CO-Founder</div>
                </div>
            </div>
            <div class="single-member position-relative">
                <div class="content-wrapper position-relative">
                    <img class="our-mission-graphic"src="{{asset('/images/icons/team/dor.png')}}" /> 
                    <div class="quote">
                        <div>
                            <i class="fa-light fa-quote-left"></i>
                        </div>
                        <div class="quote-text secondary-color">
                            Fitness addict with a mission of integrating life with art & culture.
                        </div>
                    </div>
                </div>
                <div class="team-member-details">
                    <i class="fa-solid fa-message-lines"></i>
                    <h5 class="name">Dor Sarig</h5>
                    <div class="position secondary-color">CO-Founder</div>
                </div>
            </div>
            <div class="single-member position-relative">
                <div class="content-wrapper position-relative">
                    <img class="our-mission-graphic"src="{{asset('/images/icons/team/shahar.png')}}" /> 
                    <div class="quote">
                        <div>
                            <i class="fa-light fa-quote-left"></i>
                        </div>
                        <div class="quote-text secondary-color">
                            Fitness addict with a mission of integrating life with art & culture.
                        </div>
                    </div>
                </div>
                <div class="team-member-details">
                    <i class="fa-solid fa-message-lines"></i>
                    <h5 class="name">Shahar Shmueli</h5>
                    <div class="position secondary-color">CO-Founder</div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection