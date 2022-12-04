@extends('layouts.frontend-main', ['title' => 'Playlistmap Pricing', 'bodyClass' => 'pricing'])
@section('content')
    <section class="pricing-section pricing-section-hero" style="background:linear-gradient(180deg, rgba(18, 18, 18, 0) -112.13%, rgba(18, 18, 18, 0.787848) -0.19%, #121212 42.6%), url({{asset('images/bg/hero1.webp')}});">
        <div class="wrap">
            <h3 class="text-center">Instantly Connect With Playlist Curators</h3>
            @if(user() && user()->subscription()->plan->isFree())
                <div class="text-center start-for-free">Start your <span class="yellow-color">Free Trial</span> today, you cancel or change plans at anytime!</div>
            @else
                <div style="height:40px"></div>
            @endif
            <div class="container">
                <div class="monthly-yearly-wrapper d-flex align-items-center justify-center month">
                    <div class="text pe-2 month">Pay Monthly</div>
                    @include('frontend.components.forms.toggle', ['name' => 'yearly-monthly-toggle', 'id' => 'yearly-monthly-toggle'])   
                    <div class="text ps-2 year">Pay Yearly & Save <span class="green-color">20%</span></div>
                </div>
            <div>

            <div class="plans-wrapper month row">
                <!-- <div class="row g-2"> -->
                    @foreach(\App\Models\Plan::all() as $key => $plan)
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class=" plan-container mb-2 {{$plan->invoice_interval}} {{$plan->isFree()? "free": ""}} @if(isset($chosen_plan_id) && $chosen_plan_id == $plan->id) current-plan @endif {{strtolower($plan->name)}}">
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

                                    @else
                                    
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

                                    @guest
                                        @php
                                            $buy_text = $plan->isFree() ? 'Get started' : 'Choose plan'
                                        @endphp
                                        <a data-toggle="modal" data-target="#register_modal">
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
                                        <div class="d-flex"><button class="primary full-width {{$currentPlanClass ?? ''}}" data-toggle="modal" {{$currentPlanClass ?? ""}} data-target="#cancel_subscription">{{$buyTextFree}} </button></div>
                                        @include('frontend.includes.modals.confirm_cancel_subscription')
                                    @else
                                        <div class="d-flex"><button class="primary full-width buyNow {{$currentPlanClass ?? ''}}" {{$currentPlanClass ?? ""}} data-plan-name="{{strtolower($plan->name)}}" data-price="{{$plan->price}}" data-plan-type="{{$plan->invoice_interval}}" data-credit="{{$plan->feature('credits')->value}}" data-plan-id="{{$plan->id}}" data-pp-id="{{$plan->paypal_id}}" onclick="ym(73260880, 'reachGoal', 'chooseplan'); return true;">{{$buyTextPay}}</button></div>
                                    @endif

                                    @endauth
                                </div>

                                <div class="align-items-center mt-2 mobile-d" data-toggle="collapse" href="#plan-detail{{$key}}" role="button" aria-expanded="false" aria-controls="plan-detail{{$key}}" style="margin-top:30px !important">
                                    Read More
                                    <span style="margin-left:5px; margin-top:2px"><i class="text-white fa-duotone fa-chevron-down"></i></span>
                                </div>
                                @if($plan->isFree())
                                    <div class="text-left mt-3 collapse" id="plan-detail{{$key}}">
                                        <div class="font-weight-medium fs-0 pl-3">Plan includes:</div>
                                        <ul class="plan-includes list-unstyled mt-3 mb-0 pl-3 secondary-color">
                                            <li class="ms-3 mt-3">3 Credits</li>
                                            <li class="ms-3 mt-3">5 Daily searches</li>
                                            <li class="ms-3 mt-3">Limited results</li>
                                            <li class="ms-3 mt-3 hide-disc">     </li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="text-left mt-3 collapse" id="plan-detail{{$key}}">
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
                        </div>
                    @endforeach
                <!-- </div> -->
            </div>
        </div>
    </section>

    <section class="m-auto premium">
        <h3 class="text-center container">Every Premium Plan Comes With</h3>
        <div class=" container row justify-content-center m-auto">
            <div class="col-lg-3 col-md-6 col-sm-12 row">
                <div class="row">
                    <div class="col-md-12 col-sm-6 self-make rounded-circle"><div class="self-make rounded-circle"><i class="fa-solid fa-unlock-keyhole" style="font-size:30px"></i></div></div>
                    <div class="col-md-12 col-sm-6 detail-title">Unrivaled Access</div>
                </div>
                <div class="detail-content">Our database of Spotify playlist curators exceeds 10,000 making it the largest in the world.</div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 row">
                <div class="row">
                    <div class="col-md-12 col-sm-6 self-make rounded-circle"><div class="self-make rounded-circle"><i class="fa fa-sliders" style="font-size:30px"></i></div></div>
                    <div class="col-md-12 col-sm-6 detail-title">Robust Filters</div>
                </div>
                <div class="detail-content">Set search criteria so you only find playlist curators that are highly relevant to you..</div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 row">
                <div class="row">
                    <div class="col-md-12 col-sm-6 self-make rounded-circle"><div class="self-make rounded-circle"><i class="fa-regular fa-envelope" style="font-size:30px"></i></div></div>
                    <div class="col-md-12 col-sm-6 detail-title">Pitching Emails</div>
                </div>
                <div class="detail-content">Use our customizable templates to boost your open rate, create valuable connections, and get accepted to your ideal playlists.</div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 row">
                <div class="row">
                    <div class="col-md-12 col-sm-6 self-make rounded-circle"><div class="self-make rounded-circle"><i class="fa fa-headset" style="font-size:30px"></i></div></div>
                    <div class="col-md-12 col-sm-6 detail-title">Customer Support</div>
                </div>
                <div class="detail-content">Our outstanding live chat support is available on working hours. Contact our customer support team 24/7 at support@PlaylistMap.com</div>
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

<style>
    .hide-disc::marker{
        font-size:0;
    }

    .mobile-d{
        display:none;
    }

    .self-make{
        width:80px !important;
        height:80px;
        position: relative;
        background-color: rgba(190, 40, 29, 10%);
    }
    
    section.premium .detail-title{
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        line-height: 36px;
        color: #BE281D;
    }

    section.premium{
        margin:80px auto !important; 
    }

    section.premium .detail-content{
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: -0.0044em;
        color: #C0C0C0;
    }

    .self-make .self-make{
        position:absolute;
        right:-10px;
        display:flex;
        justify-content:center;
        align-items:center;
        padding-right:10px;
    }

    @media screen and (min-width:768px){
        div.text-left.mt-3.collapse{
            display:block!important;
        }
    }


    @media screen and (max-width:767px){
        .pe-2.month{
            display:none;
        }

        .row:has(.self-make) .detail-title{
            text-align:center;
            margin:auto;
        }

        .row:has(.self-make){
            margin: 25px auto !important;
        }

        .col-sm-6{
            width:50%;
        }

        .mobile-d{
            display:block;
        }
    }
</style>
@endsection