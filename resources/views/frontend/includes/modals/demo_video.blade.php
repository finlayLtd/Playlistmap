<!-- Modal -->
<div class="modal fade" id="demoVideoModal" tabindex="-1" aria-labelledby="demoVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header position-relative border-0">
                <h6 class="modal-title" id="demoVideoModalLabel">How to User PlaylistMap</h6>
                <div class="rounded-circle" 
                        style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-x"></i>
                </div>
            </div>
            <div class="modal-body">
                <!-- <form action="{{ route('frontend.playlists.report') }}" method="post">
                    @csrf
                    <input type="hidden" name="playlist_id" id="playlist_id">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control resize-none"  name="message" id="message" rows="3" required></textarea>
                    </div>
                    <div class="pt-3 border-0 d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Submit</button>
                    </div>
                </form> -->
                <video id="vid" width="320" height="240" loop="" class="w-100" controls>
                    <source src="{{asset('assets/How-to-use.mp4')}}" type="video/mp4">
                    <source src="{{asset('assets/How-to-use.ogg')}}" type="video/ogg">
                        Your browser does not support the video tag.
                </video>
                <div class="pt-3 border-0 d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 start-for-free" data-dismiss="modal" data-toggle="modal" data-target="#register_modal">Start Free Trial</button>
                </div>
            </div>

        </div>
    </div>
</div>