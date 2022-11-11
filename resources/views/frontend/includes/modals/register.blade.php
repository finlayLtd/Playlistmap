<div class="modal fade" id="register_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content login-modal position-relative">
            <div class="position-absolute register-modal-close mobile-d-none rounded-circle x-button d-flex justify-content-center align-items-center" 
                    data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="container justify-content-center m-auto row">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 login-info">
                            <div class="justify-content-center mobile-d"><i class="fa-duotone fa-dash" style="height:80px"></i></div>
                            <h4>Sign Up to PlaylistMap</h4>
                            <img class="mobile-d-none" width="290px" height="242px" src="{{ asset('images/frontend/register-modal.png') }}"></img>
                            <p class="mobile-d-none">Get access to thousands of curators who want to discover your music.</p>
                        </div>
                        <div class="col-md-6 col-sm-12 login-input">
                            <div class="text-center h5 mobile-d-none">Account Log in</div>
                            <p>Get started with 3 free credits. No credit Card is needed </p>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="spotify-artist-id" value="{{ old('spotify-artist-id') }}"/>
                                <div class="mb-3">
                                    <input id="name" type="text" class="auth-info form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="Name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <x-error field="name"></x-error>
                                </div>
                                <div class="mb-3">
                                    <input id="email" type="email" class="auth-info form-control @error('email') is-invalid @enderror"
                                            name="email" placeholder="Email" value="{{ old('email') }}" required  >
                                    <x-error field="email"></x-error>
                                </div>
                                <div class="mb-3 ">
                                    <div class="d-flex justify-content-between">
                                    </div>
                                    <input id="password" type="password" placeholder="Password"
                                            class="auth-info form-control @error('password') is-invalid @enderror"
                                            name="password" required autocomplete="current-password">
                                    <x-error field="password"></x-error>
                                </div>
                                <div class="mb-3 ">
                                    <input id="password-confirm" type="password" class="auth-info form-control"
                                            name="password_confirmation" placeholder="Confirm Password"
                                            required autocomplete="new-password">
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input @error('agree') is-invalid @enderror" type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : '' }} >
                                    <label class="form-check-label" for="agree" target="_blank">By signing up you agree to Playlist Map's<a href="/terms"> Terms of Use</a> and <a href="/privacy" target="_blank"> Cookie & Privacy Policy.</a></label>
                                    <x-error field="agree"></x-error>
                                </div>
                                <div class="mt-2 d-flex justify-content-between">
                                    <div class="d-flex">
                                        <p class="m-auto">Already a Member?</p>
                                    </div>
                                    <div class="text-white">
                                        <div class="btn btn-primary bg-transparent rounded-pill px-3 login-button" data-toggle="modal" data-target="#login_modal" style="border:1px solid gray">
                                            <i class="fa-solid fa-sign-in pe-2"></i>Login
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        $(".register-modal-close").click(function(){
            $('#login_modal').addClass('show');
        });

        $(".login-button").click(function(){
            $('#login_modal').addClass('show');
            $('#register_modal').css("display","none");
        });

    });
</script>

<style>

    form svg77777777777777777777{
        margin-left: -30px;
        cursor: pointer;
    }

    .x-button{
        width:35px; 
        height:35px;
        right:0px;
        top:-10%;
        background-color: #121212;
    }

    #register_modal .modal-dialog{
        max-width: 100%;
    }

    .login-info img{
        margin-top: 48px;
        margin-bottom: 48px;
    }

    .login-info, .login-input{
        padding:1.5em;
    }
    
    .login-modal{
        width:66%;
    }

    .auth-info.form-control:focus.form-control{
        border:none;
    }

    .auth-info.form-control, .auth-info.form-control:focus{
        border-radius: 10px;
        background-color: #1b1b1b;
        color:white;
        border:2px solid #1b1b1b;
    }

    .modal-content{
        position: relative;
    }
    
    input:-webkit-autofill{
        -webkit-box-shadow: #1b1b1b 0 0 0 1000px inset !important;
        -webkit-text-fill-color:white !important;
    }
    
    .auth-info.form-control:focus{
        border:1px solid blue
    }
    
    @media screen and (max-width:767px){
        
        .login-info, .login-input{
            padding:10px;
        }

        .modal-content{
            border-radius: 50px 50px 0px 0px;
            width: 100%;
            position: absolute !important;
            gap:48px;
            bottom:0px;
        }

        #register_modal .container{
            padding:0px !important;
        }

    }
</style>