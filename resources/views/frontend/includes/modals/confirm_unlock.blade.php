<div class="modal fade" id="unlock_playlist_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">      
        <div class="modal-content position-relative">
            <div class="position-absolute rounded-circle x-button d-flex justify-content-center align-items-center" 
                    data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-header border-0 pb-0">
                <div class="justify-content-center mobile-d"><i class="fa-duotone fa-dash" style="height:80px"></i></div>
                <h5 class="modal-title text-center w-100 h3">Unlock contact information?</h5>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="container playlist_unlock_detail align-items-center d-flex text-left justify-content-center">
                    <img width="90px" height="90px" class="img-thumbnail" style="margin-right:20px">
                    <div class="d-inline-block my-5 text-truncate">
                        <span class="h6" id="playlist_name"></span>
                        <div style="font-size:16px; color:#C0C0C0">
                            <i class="fa fa-users" aria-hidden="true" style="color:#827F7F"></i>
                            Followers
                            <span id="playlist_followers"></span>
                            <i class="fa-sharp fa-solid fa-calendar-week" style="color:#827F7F; border-left: 1px #827f7f solid; padding-left:5px;"></i>
                            Tracks
                            <span id="playlist_tracks"></span>
                        </div>
                        <div style="font-size:12px">updated:  <span id="playlist_updated" style="color:#C0C0C0"></span></div>
                    </div>
                </div>
                <form action="{{ route('frontend.playlists.unlock') }}" method="post" class="d-flex container">
                    @csrf
                    <input type="hidden" name="playlist_id" id="playlist_id">
                    <p class="pt-xl-2 d-inline w-25">{{ $user->credits }} Credits Left</p>
                    <div class="d-iline-block w-75 pr-5" style="text-align:right">
                        <button id="cancelbtn" style="box-shadow: none; border:1px solid white; color:white; padding:5px 24px" 
                            type="button"  class="btn btn-sm rounded-pill bg-transparent" data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                        <button style="font-size: 16px; padding:5px 24px" class="btn btn-sm rounded-pill btn-danger confirmUnlock" >Unlock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    #cancelbtn:hover{
        background-color: #1b1b1b !important;
    }
    .x-button{
        width:35px; 
        height:35px;
        right:0px;
        top:-18%;
    }

    .modal-dialog .position-absolute{
        background: #121212;    
    }

    .modal-content {
        border-radius:10px;
    }

    .modal-header .mobile-d{
        display:none !important;
    }

    @media screen and (max-width:767px){
        .modal-dialog .position-relative{
            position:absolute !important;
            bottom:0;
        }

        .modal-dialog .position-absolute{
            display: none !important;
        }

        .modal-content{
            border-radius: 50px 50px 0px 0px;
        }

        .modal-header{
            display:block !important;
        }

        .modal-header .mobile-d{
            display:flex !important;
        }

        .iframe:has(.chat-bubble){
            display:none;
        }
    }
</style>