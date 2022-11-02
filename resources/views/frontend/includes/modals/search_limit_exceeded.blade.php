<!-- Modal -->
<div class="modal fade" id="search_limit_exceeded_modal" tabindex="-1" aria-labelledby="search_limit_exceeded_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title text-center w-100 text-warning">
                    <i class="fal fa-exclamation-triangle mr-2"></i>
                    You have reached your daily limit.
                </h5>
            </div>
            <div class="modal-body">
                <p>Please upgrade your account to keep using {{ config('app.name') }} or you can come back in 24 hours
                    when your daily limit resets.</p>
                <a href="/profile#myunlocks">You can access your unlocks here</a>
                <br></br>
                <div class="text-center">
                    <a href="{{ route('frontend.profile.plans') }}" class="btn btn-sm btn-success">Upgrade</a>
                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal" aria-label="Close">No
                        Thanks
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
