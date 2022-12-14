<div class="trusted-by @if(isset($position) && $position === "center") secondary-color @endif">
    @if(isset($position) && $position === "center")
    <h5 class="text-center">Trusted by</h5>
    <div class="d-flex justify-content-center  align-items-center mt-3">
        @else
        <div class="d-flex justify-content-start align-items-center">
            <div class="text">
                <h5>Trusted by</h5>
            </div>
            @endif
            <ul class="m-0 partners" style="display:block;">
                <li class="itemList" >
                    <img alt="" src="{{asset('/images/icons/partners/ditto.svg')}}" class="heightBanner" />
                </li>
                <li class="itemList" >
                    <img alt="" src="{{asset('/images/icons/partners/alteza.svg')}}" class="heightBanner"/>
                </li>
                <li class="itemList" id="thirdImage" >
                    <img alt="" src="{{asset('/images/icons/partners/weraveyou.svg')}}" class="heightBanner"/>
                </li>
                <br class="breakMobile">

                <li class="itemList">
                    <img alt="" src="{{asset('/images/icons/partners/vini-vici.svg')}}" class="heightBanner marginTop20" id="startPoint"/>
                </li>
                <li class="itemList" style="margin-right: 0px !important;">
                    <img alt="" src="{{asset('/images/icons/partners/fangage.svg')}}" class="heightBanner marginTop20" />
                </li>
            </ul>
        </div>
    </div>

<style>
    .itemList{
        display:inline; margin-right: 30px;
    }
    
    .breakMobile{
        display: none;
    }

    .heightBanner{
        height: 30px;
    }

    @media screen and (max-width:767px){
        .breakMobile{
            display: block;
        }

        .heightBanner{
            height: 20px;
        }

        #thirdImage{
            margin-right: 0px !important;
        }

        .marginTop20{
            margin-top: 20px;
        }

        #startPoint{
            margin-left: 20px;
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

        .text1{
            font-family: 'Lato';
            font-style: normal;
            font-weight: 600;
            font-size: 20px;
            line-height: 32px;
            letter-spacing: -0.15px;
            color: #FFFFFF;
        }
    }
</style>

