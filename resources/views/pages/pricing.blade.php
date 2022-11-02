@extends('layouts.frontend-main', ['title' => 'Playlistmap Pricing', 'bodyClass' => 'pricing'])
@section('content')
<section class="pricing-section pricing-section-hero" style="background:linear-gradient(180deg, rgba(18, 18, 18, 0) -112.13%, rgba(18, 18, 18, 0.787848) -0.19%, #121212 42.6%), url({{asset('images/bg/hero.jpg')}})">
    <div class="wrap">
        <h3 class="text-center">Instantly Connect With Playlist Curators</h3>
        <div class="text-center start-for-free">Start your <span class="yellow-color">Free Trial</span> today, you cancel or change plans at anytime!</div>
        <div class="monthly-yearly-wrapper d-flex align-items-center justify-center month">
            <div class="text pe-2 month">Pay Monthly</div>
            @include('frontend.components.forms.toggle', ['name' => 'yearly-monthly-toggle', 'id' => 'yearly-monthly-toggle'])   
            <div class="text ps-2 year">Pay Yearly & Save <span class="green-color">20%</span></div>
        </div>

        <div class="plans-wrapper month">
            <div class="row g-2">
                @foreach(\App\Models\Plan::all() as $plan)
                <div class="col plan-container {{$plan->invoice_interval}} {{$plan->isFree()? "free": ""}} @if(isset($chosen_plan_id) && $chosen_plan_id == $plan->id) current-plan @endif {{strtolower($plan->name)}}">
                    @if($plan->name == 'Premium')
                    <div class="most-popular">Most popular
                        <i class="fa-solid fa-stars"></i>
                    </div>
                    @endif
                    <div class="text-center">
                        <h5 class="font-weight-normal my-0 secondary-color text-start mb-3">{{ $plan->name }}</h5>
                        <h4 class="plan-price price-month text-start mb-1">$ <span class="price">{{ floor($plan->price) }}</span> <sup class="tertiary-color">/Month</sup></h4>

                        @if($plan->name == 'Free')
                        <div class="year-price d-flex justify-content-between align-items-center">
                            <div class="tertiary-color">$0/year</div>
                        </div>
                        @endif

                        @if($plan->invoice_interval === "year")
                        <div class="year-price d-flex justify-content-between align-items-center">
                            @if($plan->name === "Plus")
                            <div class="tertiary-color fs-body">${{floor(11.2 * 12)}}/year</div>
                            @else
                            <div class="tertiary-color fs-body">${{floor($plan->price * 12)}}/year</div>
                            @endif
                            <div class="dark-green-background green-color p-1 br-30 fs-small">Save ${{(($plan->price / 0.8) - $plan->price) * 12}}</div>
                        </div>

                        @endif

                        <div class="credits text-start secondary-color mb-3 mt-3">
                            {{ $plan->feature('credits')->value }} Credits @if(!$plan->isFree())/ {{ucfirst($plan->invoice_interval) ?? ""}}</small>@endif
                            <span data-toggle="tooltip" data-placement="right" title="A credit is the currency you use to unlock a Spotify playlist curator’s contact information on our platform. One credit gets you one unlock.">
                                <i class="fa-solid fa-circle-info secondary-color"></i>
                            </span>
                        </div>

                        <?php /*

                          @if($plan->name == 'Free')
                          <h2 class="font-weight-medium my-3" style="font-size: 18px; opacity: 0;">
                          <sup class="font-weight-normal fs-2 mr-1" style="font-size: 18px !important;">$</sup>{{ $plan->price }}<small class="fs--1 text-700">/ Month</small>
                          </h2>
                          <h2 class="font-weight-medium my-3" >
                          <sup class="font-weight-normal fs-2 mr-1">$</sup>{{ floor(($plan->price / 2)*100)/100 }}<small class="fs--1 text-700">/ Month</small>
                          </h2>
                          @else
                          <h2 class="font-weight-normal my-3" style="font-size: 18px;">
                          <del>
                          <sup class="font-weight-normal fs-2 mr-1" style="font-size: 18px !important;">$</sup>{{ $plan->price }}<small class="fs--1 text-700">/ Month</small>
                          </del>
                          <span class="font-weight-normal" style="color:#ff2967;">(-50%)</span>
                          </h2>
                          <h2 class="font-weight-medium my-3">
                          <sup class="font-weight-normal fs-2 mr-1">$</sup>{{ floor(($plan->price / 2)*100)/100 }}<small class="fs--1 text-700">/ Month</small>
                          </h2>
                          @endif

                         * 
                         * 

                          <h5 class="font-weight-medium my-4">
                          {{ $plan->feature('credits')->value }} Credits         <span data-toggle="tooltip" data-placement="right" title="A credit is the currency you use to unlock a Spotify playlist curator’s contact information on our platform. One credit gets you one unlock.">
                          <i class="far fa-question-circle"></i>
                          </span>
                          @if(!$plan->isFree())
                          <small class="fs--1 text-700">/ Monthly</small>
                          @endif
                          </h5>
                         *                                  */ ?>


                        <?php
//                        var_dump($chosen_plan_id);
//                        exit;
                        ?>

                        @guest
                        @php
                        $buy_text = $plan->isFree() ? 'Get started' : 'Choose plan'
                        @endphp
                        <a style="" href="{{ route('register') }}">
                            <button class="tertiary">{{$buy_text}}</button> 
                        </a>
                        @endguest

                        @auth

                        @php
                        $buyTextFree = 'Choose Plan';
                        $buyTextPay = "Choose Plan";
                        $currentPlanClass = "";

                        if (isset($chosen_plan_id) && $chosen_plan_id == $plan->id){
                        $buyTextFree = 'Current Plan';
                        $buyTextPay = "Current Plan";
                        $currentPlanClass = "disabled";
                        }
                        @endphp

                        @if($plan->isFree())
                        <button class="primary full-width {{$currentPlanClass ?? ""}}" data-toggle="modal" {{$currentPlanClass ?? ""}} data-target="#cancel_subscription">{{$buyTextFree}} </button>
                        @include('frontend.includes.modals.confirm_cancel_subscription')
                        @else
                        <button class="primary full-width buyNow {{$currentPlanClass ?? ""}}" {{$currentPlanClass ?? ""}} data-plan-name="{{strtolower($plan->name)}}" data-price="{{$plan->price}}" data-plan-type="{{$plan->invoice_interval}}" data-plan-id="{{$plan->id}}" data-pp-id="{{$plan->paypal_id}}" onclick="ym(73260880, 'reachGoal', 'chooseplan'); return true;">{{$buyTextPay}}</button>
                        @endif

                        @endauth
                    </div>
                    @if($plan->isFree())
                    <div class="text-left mt-3">
                        <div class="font-weight-medium fs-0 pl-3">Plan includes:</div>
                        <ul class="plan-includes list-unstyled mt-3 mb-0 pl-3 secondary-color">
                            <li class="ms-3 mt-3">3 Credits</li>
                            <li class="ms-3 mt-3">5 Daily searches</li>
                            <li class="ms-3 mt-3">Limited results</li>
                        </ul>
                    </div>
                    @else
                    <div class="text-left mt-3">
                        <div class="font-weight-medium fs-0 pl-3">Plan includes:</div>
                        <ul class="plan-includes list-unstyled mt-3 mb-0 pl-3 secondary-color">
                            <li class="ms-3">{{$plan->feature('credits')->value}} Credits</li>
                            <li class="ms-3 mt-3">Unlimited searches</li>
                            <li class="ms-3 mt-3">{{$plan->feature('dynamic_templates')->value}} Email Templates</li>
                            <li class="ms-3 mt-3">Customer support</li>
                        </ul>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

@include('frontend.components.pages.testimonials', ['title' => 'What They Say About Us!', 'showTitleQuote' => true])
@include('frontend.components.pages.faq')


@auth
@include('frontend.includes.modals.pay_now', ['coupon' => $coupon])
@endauth
@endsection


@section('scripts')
<script>
    let stripe_key = "{{ config('services.stripe.key') }}";
</script>
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/stripe-input.js') }}"></script>
<script>
//    $(function () {
    $(document).ready(function () {

    });
</script>
@endsection