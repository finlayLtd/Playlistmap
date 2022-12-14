@extends('layouts.auth')

@section('content')
    <div class="row flex-center min-vh-100 py-6 text-center">
        <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
            <a class="d-flex flex-center mb-4" href="{{route('home')}}">
                <img alt="" class="mr-2 w-50" src="{{ asset('images/logo_inverse.webp') }}" >
            </a>
            <div class="card">
                <div class="card-body p-4 p-sm-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h5 class="mb-0">Forgot your password?</h5><small>Enter your email and we'll send you a reset link.</small>
                    <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
                        <x-error field="email"/>
                        <div class="mb-3">
                            <button class="btn btn-primary d-block w-100 mt-3" type="submit" >Send Password Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
