@extends('layouts.frontend')

@section('content')
    <div class="card" style="text-align: center;" >
        <div class="card-header">
            <h5 class="mb-0">Verify Your Email Address</h5>
        </div>

        <img id="verifyemail" class="rounded mx-auto d-block" src="/frontend/img/check-email.png" >
        <div class="card-body  bg-light">
            
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
                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('RESEND ACTIVATION EMAIL') }}</button>
            </form>
        </div>
    </div>
@endsection
