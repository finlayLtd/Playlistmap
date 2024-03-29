<div class="modal fade" id="login_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content login-modal position-relative">
            <div class="position-absolute rounded-circle x-button d-flex justify-content-center align-items-center" 
                    style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-auto container row">
                    <div class="col-md-6 col-sm-12 login-info">
                        <div class="justify-content-center mobile-d"><i class="fa-duotone fa-dash" style="height:80px"></i></div>
                        <h4>Login to PlaylistMap</h4>
                        <img alt="" class="mobile-d-none" width="290px" height="242px" src="{{ asset('images/frontend/login-modal.webp') }}"></img>
                        <p class="mobile-d-none">Welcome back! to your PlaylistMap account</p>
                    </div>
                    <div class="col-md-6 col-sm-12 login-input">
                        <div class="container">
                            <div class="text-center h5">Account Log in</div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="my-3">

                                    <input id="email" type="email" class="auth-info form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                </div>
                                <div class="my-3">
                                    <div class="position-relative">
                                        <input id="password" placeholder="password" type="password" class="auth-info form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="mt-2 text-left" >
                                        <input class="form-check-input" type="checkbox" style="cursor:pointer" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} checked>
                                        <label class="form-check-label" for="remember" style="cursor:pointer">Remember me</label>
                                    </div>
                                    <div class="mt-2 text-right">
                                        <a class="fs--1 mt-3 forget_link" data-toggle="modal" style="cursor:pointer" data-target="#forget_modal">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-danger rounded-pill btn-block mt-3 w-100" type="submit" name="submit" style="background: #BE281D;"  data-toggle="modal" data-target="#loader">
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>Log in
                                    </button>
                                </div>
                                <div class="mt-2 d-flex justify-content-between">
                                    <div class="d-flex">
                                        <p class="m-auto">New to PlaylistMap?</p>
                                    </div>
                                    <div class="text-white">
                                        <div class="btn btn-primary bg-transparent rounded-pill px-3 register-button" data-toggle="modal" data-target="#register_modal" style="border:1px solid gray">
                                            <i class="fa-solid fa-user-plus pe-2"></i>Sign Up
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
        
        $(".register-button").click(function(){
            $("#login_modal").modal('hide')
            $("#register_modal").modal("show");
        });

        $("#login_modal div[data-dismiss]").click(function(){
            if($("div[data-dismiss='modal]")!=null)
                $("div[data-dismiss='modal]").trigger('click');
        })
        
        $(".forget_link").click(function(){
            $("#login_modal.show").modal("hide");
            $("#forget_modal").modal("show");
        });

    });

</script>

<style>

    form svg77777777777777777777{
        margin-left: -30px;
        cursor: pointer;
    }

    #login_modal .x-button{
        width:35px; 
        height:35px;
        right:0px;
        top:-10%;
        z-index:3000;
        background-color: #121212;
    }

    #login_modal .modal-dialog{
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

        #login_modal .x-button{
            right:20px;
            top:20px;
        }

        .modal-content{
            border-radius: 50px 50px 0px 0px;
            width: 100%;
            position: absolute !important;
            gap:48px;
            bottom:0px;
        }

        #login_modal .container{
            padding:0px !important;
        }

    }
</style>