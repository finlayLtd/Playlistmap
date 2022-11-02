<!-- Modal -->
<div class="modal fade" id="demoVideoModal" tabindex="-1" aria-labelledby="demoVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title" id="demoVideoModalLabel">Send Feedback</h6>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('frontend.playlists.report') }}" method="post">
                    @csrf
                    <input type="hidden" name="playlist_id" id="playlist_id">
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control resize-none"  name="message" id="message" rows="3" required></textarea>
                    </div>
                    <div class="text-right pt-3 border-0">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
