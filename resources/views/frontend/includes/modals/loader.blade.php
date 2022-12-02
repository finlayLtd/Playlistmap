<div class="modal fade" id="loader" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content bg-transparent border-0" style="background-color:transparent!important;">
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="music-animation-loader">
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                    <div class="music-animation-line"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    /* Music Animation Component */

    .music-animation-loader{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        height: 90px;
    }

    .music-animation-loader .music-animation-line{
        width: 12px;
        height: 4px;
        border-radius: 10px;
        background: #fff;
        animation: musicloaderanimation 1.3s ease-in-out infinite;
    }

    .modal.show#loader .modal-content{
        top:50%;
    }

    @keyframes musicloaderanimation{
        0%{
            height: 4px;
        }
        50%{
            height: 90px;
        }
        100%{
            height: 4px;
        }
    }

    .music-animation-loader .music-animation-line:nth-child(1),
    .music-animation-loader .music-animation-line:nth-child(10){
        background: #d715d7;
        background: #d715d7;
        animation-delay: 1s;
    }

    .music-animation-loader .music-animation-line:nth-child(2),
    .music-animation-loader .music-animation-line:nth-child(9){
        background: #d71515;
        background: #BE281D;
        animation-delay: 0.8s;
    }

    .music-animation-loader .music-animation-line:nth-child(3),
    .music-animation-loader .music-animation-line:nth-child(8){
        background: #d71579;
        background: #1db954;
        animation-delay: 0.6s;
    }

    .music-animation-loader .music-animation-line:nth-child(4),
    .music-animation-loader .music-animation-line:nth-child(7){
        background: #d76715;
        background: #F0882A;
        animation-delay: 0.4s;
    }

    .music-animation-loader .music-animation-line:nth-child(5),
    .music-animation-loader .music-animation-line:nth-child(6){
        background: #d7c415;
        background: #FBDE4B;
        animation-delay: 0.2s;
    }

    /* End of music Animation Component*/
</style>