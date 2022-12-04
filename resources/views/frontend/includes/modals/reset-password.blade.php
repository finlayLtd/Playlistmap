<div class="modal fade" id="reset_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content reset-modal position-relative">
            <div class="position-absolute reset-modal-close rounded-circle x-button d-flex justify-content-center align-items-center" 
                    style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">

                <div class="m-auto container py-4">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="mb-0">{{ __('Reset Password') }}</h5>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" @if(isset($request)) value="{{ $request->route('token') }}" @endif>

                        <div class="form-group row mb-3">
                            <div>
                                <input id="email" type="email" class="auth-info form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $request->email ?? old('email') }}" required autocomplete="email"
                                    autofocus placeholder="{{ __('E-Mail Address') }}">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row  mb-3">
                            <div>
                                <input id="password" type="password"
                                    class="auth-info form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password" placeholder="{{ __('Password') }}">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row  mb-3">
                            <div>
                                <input id="password-confirm" type="password" class="auth-info form-control"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary rounded-pill" style="float:left">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
</script>

<style>

    form svg77777777777777777777{
        margin-left: -30px;
        cursor: pointer;
    }

    #reset_modal .x-button{
        width:35px; 
        height:35px;
        right:0px;
        top:-15%;
        z-index:3000;
        background-color: #121212;
    }

    #reset_modal .modal-dialog{
        max-width: 100%;
    }
    
    .reset-modal{
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

        #reset_modal .x-button{
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

        #reset_modal .container{
            padding:0px !important;
        }

    }
</style>