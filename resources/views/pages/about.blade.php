@extends('layouts.frontend-main', ['title' => 'Playlistmap About', 'bodyClass' => 'about'])
@section('content')
<section class="about-section about-section-hero" style="background:linear-gradient(180.39deg, rgba(18, 18, 18, 0) -5.24%, rgba(18, 18, 18, 0.787848) 75.74%, #121212 94.1%), url({{asset('images/bg/about-hero.webp')}}); ">
    <div class="wrap">
        <div class="main">

            <img alt="" class="logo d-block m-auto" src="{{ asset('images/logo-w.webp') }}"  width="150" />

            <div class="about-headline text-center mt-5">Created by musicians for musicians</div>
            @include('frontend.components.pages.trusted-by', ['position' => 'center'])
        </div>
        <div class="text-center scroll-down">
            <img alt="" class="scroll-down-top me-2" src="{{asset('/images/icons/scroll-down.svg')}}" />
            <img alt="" class="scroll-down-bottom me-2" src="{{asset('/images/icons/scroll-down-hover.svg')}}" />
            <span>Scroll Down</span>
        </div>
    </div>
</section>

<section class="about-section about-section-why-playlistmap">
    <div class="wrap">
        <div class="position-relative inner-wrapper">
            <div class="why-we-created-content pt-4">
                <h1 class="reSize1">
                    <span class="red">Why We Created</span><br>
                    PlaylistMap
                </h1>
                <h5 class="secondary-color reSize2">
                    Artists are struggling to promote their music, reach the right listeners, and get discovered. Curators are struggling to grow their playlists and gain more followers without getting spammed by irrelevant song submissions.
                    <br>We built PlaylistMap to solve both problems.
                </h5>

            </div>
            <div class="guitar-wrapper">
                <img alt="" class="scroll-down-top me-2 guitar" src="{{asset('/images/bg/guitar.webp')}}"  />
                <img alt="" class="guitar-music"src="{{asset('/images/graphics/guitar-graphic.svg')}}" /> 
            </div>
        </div>

    </div> 
</section>

<section class="about-section about-section-what-is-playlistmap">
    <div class="wrap">


        

        <div class="what-is-playlistmap mt-5">
            <h3 class="reSize3">What is PlaylistMap? </h3>
            <h5 class="secondary-color reSize4">
                PlaylistMap is the first-ever Artist Discovery Platform. Powered by our proprietary AI algorithm, we use advanced technology and data-driven insights to simplify discovery for artists, labels, and curators. 
                <br><br>
                With PlaylistMap, independent artists and labels can pinpoint hyper-relevant playlists and pitch their songs directly to curators. Curators gain detailed insights on their listeners and a stream of song submissions that suit their playlists. 
            </h5>
        </div>

        <div class="d-flex justify-content-between our-mission-wrapper">
            <div>

                <div class="position-relative inner-wrapper">
                        <div class="why-our-mission pt-4">
                            <h3 class="mt-5 reSize3">Our Mission
                                <img alt="" class="our-mission-graphic"src="{{asset('/images/graphics/mission-graphic.svg')}}" /> 
                            </h3>
                            <h5 class="secondary-color reSize5">
                                We empower artists to own their music careers and succeed in the digital streaming world, without needing to rely on labels or expensive marketing campaigns.
                                <br><br>
                                At the same time, we’re improving curators’ experience by helping them reduce irrelevant pitches and providing key data on their playlists so they can increase their followings.
                            </h5>

                        </div>
                        <div class="missionWrapper">
                            <img alt="" class="scroll-down-top me-2 guitar" src="{{asset('/images/bg/curators.webp')}}"  />
                        </div>
                    </div>

                </div> 
            </div>
            
        </div>
    </div>
</section> 

@include('frontend.components.pages.statistics', ['page' => 'about'])


<section class="about-section about-section-team" style="margin-bottom: 60px !important;">
    <div class="wrap">
        <h3 class="text-center">Our Team</h3>
        <div class="row mt-5">
            <div class="col-6 col-md-4 text-center d-flex" style="justify-content: center;">
                <div class=" single-member position-relative">
                    <div class="content-wrapper position-relative">
                        <img alt="" class="our-mission-graphic"src="{{asset('/images/icons/team/shahar.webp')}}" /> 
                        <div class="quote">
                            <div>
                                <i class="fa-light fa-quote-left"></i>
                            </div>
                            <div class="quote-text secondary-color otherSizeOnMobile2">
                                Fitness addict with a mission of integrating life with art & culture.
                            </div>
                        </div>
                    </div>
                    <div class="team-member-details">
                        <i class="fa-solid fa-message-lines"></i>
                        <h5 class="name otherSizeOnMobile1">Shahar Shmueli</h5>
                        <div class="position secondary-color otherSizeOnMobile2">CO-Founder</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center d-flex" style="justify-content: center;">
                <div class=" single-member position-relative">
                    <div class="content-wrapper position-relative">
                        <img alt="" class="our-mission-graphic"src="{{asset('/images/icons/team/dor.webp')}}" /> 
                        <div class="quote">
                            <div>
                                <i class="fa-light fa-quote-left"></i>
                            </div>
                            <div class="quote-text secondary-color otherSizeOnMobile2">
                                Fitness addict with a mission of integrating life with art & culture.
                            </div>
                        </div>
                    </div>
                    <div class="team-member-details">
                        <i class="fa-solid fa-message-lines"></i>
                        <h5 class="name otherSizeOnMobile1">Dor Sarig</h5>
                        <div class="position secondary-color otherSizeOnMobile2">CO-Founder</div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 text-center d-flex marginTop120" style="justify-content: center;">
                <div class=" single-member position-relative">
                    <div class="content-wrapper position-relative">
                        <img alt="" class="our-mission-graphic"src="{{asset('/images/icons/team/shahar.webp')}}" /> 
                        <div class="quote">
                            <div>
                                <i class="fa-light fa-quote-left"></i>
                            </div>
                            <div class="quote-text secondary-color otherSizeOnMobile2">
                                Fitness addict with a mission of integrating life with art & culture.
                            </div>
                        </div>
                    </div>
                    <div class="team-member-details">
                        <i class="fa-solid fa-message-lines"></i>
                        <h5 class="name otherSizeOnMobile1">Shahar Shmueli</h5>
                        <div class="position secondary-color otherSizeOnMobile2">CO-Founder</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    

    @media screen and (max-width:767px){
        .reSize1{
            text-align: center;
            font-weight: 700;
            font-size: 40px !important;
            letter-spacing: -0.75px !important;
            line-height: 56px !important;
        }

        .reSize2{
            margin-top: 240px;
            text-align: center;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -0.0044em;
        }

        .playlistmap-statistics {
            background: linear-gradient(179deg, #BE281D 1.31%, #2062EF 100.03%);
        }

        .about .about-section-why-playlistmap .wrap .inner-wrapper .guitar-wrapper {
            position: absolute;
            top: 150px;
        }

        .about .about-section-why-playlistmap .wrap .why-we-created-content {
            max-width: 100%;
        }

        .about .about-section-why-playlistmap .wrap {
            padding: 15px !important;
        }

        .guitar{
            margin: 0px 16px !important;
            width: 90%;
        }

        .about .about-section-why-playlistmap .wrap .inner-wrapper .guitar-wrapper .guitar-music {
            position: absolute;
            bottom: -132px;
            left: 20px;
            margin: auto;
            z-index: 9999;
        }

        .about .about-section.about-section-hero .scroll-down {
            margin: 52px auto 0px;
            padding-bottom: 35px;
        }

        .about .about-section-what-is-playlistmap .wrap {
            padding: 0 16px;
            background: linear-gradient(180.18deg, rgba(27, 27, 27, 0) 1.53%, rgba(0, 0, 0, 0.677313) 29.22%, #000000 70.25%, rgba(27, 27, 27, 0) 99.88%);
            margin-bottom: 48px;
        }

        .about-section-what-is-playlistmap{
            text-align: center;
        }

        .reSize3{
            text-align: center;
            font-weight: 700;
            font-size: 40px !important;
            letter-spacing: -0.75px !important;
            line-height: 56px !important;
        }

        .reSize4{
            text-align: center;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -0.0044em;
        }

        .reSize5{
            margin-top: 270px !important;
            text-align: center;
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -0.0044em;
        }

        .why-our-mission {
            max-width: 100% !important;
            
        }

        .missionWrapper{
            position: absolute;
            top: 150px !important;
            max-width: 100% !important;
            
        }

        .about .about-section-what-is-playlistmap .wrap .what-is-playlistmap::after {
            left: -18px !important;
            width: 100% !important;
        }

        .about .about-section-what-is-playlistmap .wrap .our-mission-wrapper {
             margin-top: 0px !important;
        }

        .about .about-section-team .wrap .team-member-details {
            bottom: -106px;
        }

        .about .about-section-team .wrap .content-wrapper::after {
            width: 151.5px;
            height: 151.5px;
        }

        .about .about-section-team .wrap .content-wrapper img {
            width: 150px;
        }

        .about .about-section-team .wrap .content-wrapper {
            width: 150px;
            height: 150px;
        }

        .marginTop120{
            margin-top:120px;
        }

        .otherSizeOnMobile1{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #FFFFFF;
        }

        .otherSizeOnMobile2{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: -0.0044em;
            color: #C0C0C0;
        }
    }

    .why-our-mission {

        position: relative;
        max-width: 45%;
        z-index: 99;
        position: relative;
    }

    .missionWrapper{
        max-width: 55%;
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
    }
</style>

@endsection

