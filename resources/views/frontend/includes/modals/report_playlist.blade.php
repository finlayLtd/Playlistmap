<!-- Modal -->
<div class="modal fade" id="reportPlaylistModal" tabindex="-1" aria-labelledby="reportPlaylistModalLabel"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">      
        <div class="modal-content position-relative">
            <div class="position-absolute rounded-circle x-button d-flex justify-content-center align-items-center" 
                    style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-header border-0 pb-0">
                <div class="justify-content-center mobile-d"><i class="fa-duotone fa-dash" style="height:80px"></i></div>
                <h5 class="modal-title text-center w-100 h3">Send Feedback</h5>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="container">
                    <form action="{{ route('frontend.playlists.report') }}" method="post" class="m-4">
                        @csrf
                        <input type="hidden" name="playlist_id" id="playlist_id" value="{{$playlist->id}}">
                        <div class="form-group">
                            <label for="message" class="ms-3" style="float:left">Message</label>
                            <textarea class="form-control resize-none text-white"  name="message" id="message" rows="6" required></textarea>
                        </div>
                        <div class="text-right pt-3 border-0">
                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-5" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-5">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    textarea#message{
        border:none;
        background: #1b1b1b;
    }
    textarea#message:focus{
        border: 2px solid #2B3DD0; 
    }
</style>