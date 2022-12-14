<section class="{{$page ?? ""}}-section {{$page ?? ""}}-section-statistics playlistmap-statistics">
    <div class="wrap">
        <img alt="" class="graphic graphic-left deleteIcon" src="{{asset('/images/graphics/statistics-graphic-left.svg')}}" />
        <img alt="" class="graphic graphic-right deleteIcon" src="{{asset('/images/graphics/statistics-graphic-right.svg')}}" />
        <img alt="" class="graphic graphic-bottom deleteIcon" src="{{asset('/images/graphics/statistics-graphic-bottom.svg')}}" />
        <h2 class="text-center titleForStatistics">PlaylistMap By The Numbers</h2>
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 col-sm-12 d-flex text-left staticsImage">
                <img alt="" class="step-image step4 " src="{{asset('/images/graphics/statistics1.svg')}}" />
                <div class="d-flex flex-column justify-content-between">
                    <div class="text">
                        <h4>100k</h4>
                        <h6>Playlists</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 d-flex text-left staticsImage">
                <img alt="" class="step-image step4" src="{{asset('/images/graphics/statistics2.svg')}}" />
                <div class="d-flex flex-column justify-content-between">
                    <div class="text">
                        <h4>100M</h4>
                        <h6 class="text-truncate str-trick">Potentials Listeners</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 d-flex text-left staticsImage">
                <img alt="" class="step-image step4" src="{{asset('/images/graphics/statistics3.svg')}}" />
                <div class="d-flex flex-column justify-content-between">
                    <div class="text">
                        <h4>150</h4>
                        <h6>Genres</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    
    .staticsImage{
        justify-content: center;
    }

    .step-image{
        margin-right: 10px;
    }

    @media screen and (max-width:767px){
        .deleteIcon{
            display:none;
        }
        .titleForStatistics{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 34px;
            line-height: 44px;
            letter-spacing: -0.75px;
            color: #FFFFFF;
        }
        
        .row:has(.staticsImage){
            gap:2rem;
        }

        .playlistmap-statistics {
            background: linear-gradient(95.34deg, #BE281D 1.31%, #2062EF 100.03%);
            border-radius: 30px;
            padding: 30px !important;
            margin: 16px !important;
            z-index: 200;
            position: relative;
        }

        .staticsImage{
            margin-top: 20px;
            justify-content: start;
        }
    }

    @media screen and (max-width:380px){
        .str-trick{
            width: 75%;
        }
    }

</style>
