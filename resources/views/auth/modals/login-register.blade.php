

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#login-modal">
    Login Modal
</button>


<div class="modal fade" id="login-modal" tabindex="-1" aria-labelledby="login-modal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <img class="loader" src="{{asset('images/icons/loader-white.gif')}}" />
            <button  data-dismiss="modal" aria-label="Close" style="background: none;
                     border: none;
                     position: absolute;
                     left: 12px;
                     top: 12px;">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-header border-0 pb-0">

            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4>Log in to PlaylistMap</h4>
                        <img src="" />
                        <p>Welcome back! to your PlaylistMap account</p>
                    </div>
                    <div>
                        <div class="login">
                            <button id="login-with-spotify">
                                <i class="fa-brands fa-spotify"></i>Spotify
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>