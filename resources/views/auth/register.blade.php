@extends('layouts.auth')

@section('scripts')
<script> var homeurl = "{{ url('/')}}";</script>
<script
    src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
@endsection



@section('content')



<div id="topregpage" class="row min-vh-100 flex-center g-0">
    <div class="col-lg-8 col-xxl-5 py-3 position-relative">

        <div class="card overflow-hidden z-index-1">
            <div class="card-body p-0">
                <div class="row g-0 h-100">
                    <div id="bannersidemobile" class="col-md-5 text-center bg-card-gradient">
                        <div   class="position-relative p-4 ">
                            <div class="bg-holder bg-auth-card-shape">
                            </div>

                            <div id="bannersideregsiter" class="z-index-1 position-relative">
                                <img class="w-50 mb-5" src="{{ asset('images/frontend/register-bg.png') }}" alt="">
                                <h5 class="text-white text-left">Let’s start the journey</h5>
                                <p class="opacity-75 text-white text-left">
                                    Get access to thousands of curators who want to discover your music
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 d-flex flex-center">
                        <div class="p-4 p-md-5 flex-grow-1">
                            <div class="row flex-between-center">
                                <div class="col-auto">
                                    <h3>Create a Free Account</h3>
                                    <p>
                                        Get started with 3 free credits.

                                        No credit card is needed.
                                    </p>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input type="hidden" name="spotify-artist-id" value="{{ old('spotify-artist-id') }}"/>
                                <input type="hidden" name="spotify-artist-image" value="{{ old('spotify-artist-image') }}"/>
                                <div class="row">
                                    <div id="artist-wrapper" class="mb-3 ui artist">
                                        <label for="name" class="form-label">{{ __('Spotify Artist') }}</label>
                                        <input id="artist-id" type="text" class="form-control @error('name') is-invalid @enderror"
                                               name="artist-id" value="{{ old('artist-id') }}" autocomplete="artist-id" autofocus>
                                        <x-error field="artist-id"></x-error>
                                    </div>
                                    <div class="artist-image-wrapper col-md-6">
                                        <img id="artist-image" src="https://i.scdn.co/image/ab6761610000e5ebefeb80bd23b299d413c04d8f" />
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label for="name" class="form-label">{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    <x-error field="name"></x-error>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required  >
                                    <x-error field="email"></x-error>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <div class="d-flex justify-content-between">
                                            <label for="password" class="form-label">{{ __('Password') }}</label>
                                        </div>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password" required autocomplete="current-password">
                                        <x-error field="password"></x-error>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <div class="d-flex justify-content-between">
                                            <label for="password-confirm"
                                                   class="form-label">{{ __('Confirm Password') }}</label>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation"
                                               required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-check mb-0">
                                    <input class="form-check-input @error('agree') is-invalid @enderror" type="checkbox" name="agree" id="agree" {{ old('agree') ? 'checked' : '' }} >
                                    <label class="form-check-label" for="agree" target="_blank">I agree to Playlist Map's<a href="/terms"> Terms of Use</a> and <a href="/privacy" target="_blank"> Cookie & Privacy Policy.</a></label>
                                    <x-error field="agree"></x-error>
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-block mt-3" type="submit" name="submit">Create Account</button>
                                    <p class="mt-4"> Already have an account?
                                        <a href="{{ route('login') }}">Login Now!</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
