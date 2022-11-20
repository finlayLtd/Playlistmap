@extends('layouts.frontend-main')

@section('content')
        <h5 class="mb-0">Verify Your Email Address</h5>

        <div class="container"> 
            <img id="verifyemail" class="rounded mx-auto d-block object-fit-cover w-100" src="/frontend/img/check-email.png" >
        </div>

        <div>
            
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success" role="alert">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            {{ __('Please verify your email address.') }}
            <p style="font-size: 14px;">Follow the link in the email to validate and complete your registration.
                <br>
Be sure to check your junk/spam folder folder if you do not find the email in your box.</p>
            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-danger rounded-pill p-0 m-0 align-baseline">{{ __('RESEND ACTIVATION EMAIL') }}</button>
            </form>
        </div>
    </div>
@endsection
