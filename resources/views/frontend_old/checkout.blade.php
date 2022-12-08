@extends('layouts.frontend')

@section('styles')
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Make Payment</h5>
        </div>
        <div class="card-body bg-light">
            <form action="{{ route('frontend.subscription.checkout') }}" id="layout_form" method="post">
                @csrf
                <div id="card-element"></div>
                <button type="submit" class="btn btn-success" id="post_btn">Charge</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let stripe_key = "{{ config('services.stripe.key') }}";
    </script>
    <script src="https://js.stripe.com/v3/"></script>
@endsection
