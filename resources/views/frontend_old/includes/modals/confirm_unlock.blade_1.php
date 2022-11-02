<div class="modal fade" id="unlock_playlist_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 style="color:#262626" class="modal-title text-center w-100 ">Unlock contact information?</h5>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;
   margin: 0 !important;">
                <form action="{{ route('frontend.playlists.unlock') }}" method="post">
                    @csrf
                    <input type="hidden" name="playlist_id" id="playlist_id">
                   
                    <p class="pt-xl-2">{{ $user->credits }} Credits Left</p>
                       <hr style="color:#dbdbdb" />
                    <div class="text-center">
                        <button style="font-size: 16px;" class="btn btn-sm btn-primary confirmUnlock" >Unlock</button>
                         <hr style="color:#dbdbdb"/>
                        <button id="cancelbtn" style="color:#262626;    border: none !important;
    box-shadow: none;" type="button"  class="btn btn-sm btn-success " data-dismiss="modal" aria-label="Close">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
