<div class="modal fade" id="forget_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content forget-modal position-relative">
            <div class="position-absolute forget-modal-close rounded-circle x-button d-flex justify-content-center align-items-center" 
                    style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-auto container row">
                    <div class="col-12 login-input">
                        <div class="container">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h5 class="mb-0">Forgot your password?</h5><small>Enter the email address associated with your account, and we’ll email you a link to reset your password.</small>
                            <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <input id="email" type="email" class="auth-info form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                                <x-error field="email"/>
                                <div class="mb-3">
                                    <button class="btn btn-danger d-block rounded-pill w-100 mt-3" type="submit" >Send Password Reset Link<i class=" ms-4 fa-regular fa-paper-plane-top"></i></button>
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
        $('.forget-modal-close').click(function(){
            $("#login_modal").addClass("show");
        });
    })

</script>

<style>

    form svg77777777777777777777{
        margin-left: -30px;
        cursor: pointer;
    }

    #forget_modal .x-button{
        width:35px; 
        height:35px;
        right:0px;
        top:-7%;
        z-index:3000;
        background-color: #121212;
    }

    #forget_modal .modal-dialog{
        max-width: 100%;
    }

    .login-info img{
        margin-top: 48px;
        margin-bottom: 48px;
    }

    .login-info, .login-input{
        padding:1.5em;
    }
    
    .forget-modal{
        width:33%;
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

        #forget_modal .x-button{
            right:9px;
            top:-15px;
        }

        .modal-content{
            border-radius: 50px 50px 0px 0px;
            width: 100%;
            position: absolute !important;
            gap:48px;
            bottom:0px;
        }

        #forget_modal .container{
            padding:0px !important;
        }

    }
</style>