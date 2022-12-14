<div class="modal fade" id="verify_email" tabindex="-1" aria-labelledby="verify_email"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content position-relative">
            <div class="position-absolute verify-modal-close rounded-circle x-button d-flex justify-content-center align-items-center" 
                    style="cursor:pointer" data-dismiss="modal" aria-label="Close">
                <i class="fa-solid fa-x"></i>
            </div>
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-4">
                    <h5 class="mb-0">Verify Your Email</h5>
    
                    <div class="container my-5"> 
                        <img alt="" id="verifyemail" class="rounded mx-auto d-block" src="{{asset('/images/frontend/check-email.webp')}}" >
                    </div>
    
                    <div>
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success" role="alert">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif
                        <p style="font-size: 14px; text-align:left">
                            Follow the link in the email to validate and complete your registration.<br>
                            Be sure to check your junk/spam folder folder if you do not find the email in your box.
                        </p>
                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-pill p-0 m-0 align-baseline w-100 py-2"><i class=" me-4 fa-regular fa-paper-plane-top"></i>{{ __('RESEND ACTIVATION EMAIL') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    form svg77777777777777777777{
        margin-left: -30px;
        cursor: pointer;
    }

    .verify-modal-close{
        background-color: #121212;
        padding:10px;
        top: -45px;
        right: 0px;
    }
    
    @media screen and (max-width:767px){

        .verify-modal-close{
            top: 20px;
            right: 10px;
            z-index: 3000;
        }

    }

</style>