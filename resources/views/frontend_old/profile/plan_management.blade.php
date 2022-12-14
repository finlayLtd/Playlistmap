@extends('layouts.frontend')

@section('content')
<div class="mb-3">
    <div class="card-header text-center px-3">
        <h3 class=" font-weight-bold p-6">Instantly connect with playlist curators</h3>
    </div>

    <div  class="card-body pt-0">
        <div class="row g-0">       

            @foreach($plans as $plan)

            <div  id="planbox" class="col-lg-3  {{$chosen_plan_id == $plan->id ? 'bg-selected-plan' : '' }}">


                @if($plan->name == 'Premium')
                <div id="popularplan" class="text-center" style="
                     background: linear-gradient(
                     90deg
                     , rgba(2,0,36,1) 0%, rgba(134,67,248,1) 0%, rgba(0,212,255,1) 100%) !important;
                     color: white;
                     padding: 4%;
                     border-radius: 10px 10px 0px 0px;height: 45px;
                     margin-top: -45px;
                     ">
                    <span style="
                          width: 100%;
                          ">Most popular</span>
                </div>  
                @endif



                <div class="h-100">

                    <div class="text-center p-4">
                        <h3 class="font-weight-normal my-0">{{ $plan->name }}</h3>
                        <h2 class="font-weight-medium my-4">
                            <sup class="font-weight-normal fs-2 mr-1">$</sup>{{ $plan->price }}<small class="fs--1 text-700">/ Month</small>
                        </h2>
                        <h5 class="font-weight-medium my-4">
                            {{ $plan->feature('credits')->value }} Credits
                            @if(!$plan->isFree())
                            <small class="fs--1 text-700">/ Monthly</small>
                            @endif
                        </h5>

                        @php
                        $buy_text = $plan->isFree() ? 'Choose Plan' : 'Choose plan';
                        $btn_class = 'btn-outline-primary';
                        if ($chosen_plan_id == $plan->id){
                        $buy_text = 'Current Plan';
                        $btn_class = 'btn-success disabled';
                        }
                        @endphp
                        @if($plan->isFree())
                        <button  style="border-radius: 4px !important;
                                 text-transform: uppercase !important;
                                 font-weight: 600 !important;
                                 cursor: pointer !important;
                                 white-space: nowrap;
                                 padding: 4%;   
                                 color: white;
                                 font-size: 16px !important;" class="btn {{$btn_class}} btn-primary btn-block mt-3" data-toggle="modal" data-target="#cancel_subscription">{{$buy_text}} </button>
                        @else
                        <button onclick="ym(73260880, 'reachGoal', 'chooseplan'); return true;" style="    
                                font-size: 16px !important;
                                color: white;          
                                border-radius: 4px !important;
                                text-transform: uppercase !important;
                                font-weight: 600 !important;
                                cursor: pointer !important;
                                white-space: nowrap;
                                padding: 4%;" type="button" class="btn {{$btn_class}} buyNow btn-primary btn-block mt-3" data-plan-id="{{$plan->id}}" data-pp-id="{{$plan->paypal_id}}">{{$buy_text}}</button>
                        @endif
                    </div>




                    @if($plan->isFree())
                    <hr class="border-bottom-3 m-3">
                    <div class="text-left px-sm-4 py-4">
                        <h5 class="font-weight-medium fs-0 pl-3">Plan includes:</h5>
                        <ul class="list-unstyled mt-3 pl-3">
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> 3 Credits</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> 5 Daily searches</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Limited results</li>
                        </ul>
                    </div>
                    @else
                    <hr class="border-bottom-3 m-3">
                    <div class="text-left px-sm-4 py-4">
                        <h5 class="font-weight-medium fs-0 pl-3">Plan includes:</h5>
                        <ul class="list-unstyled mt-3 pl-3">
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span>   {{ $plan->feature('credits')->value }} Credits</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Unlimited searches</li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> <b> {{ $plan->feature('dynamic_templates')->value }} email templates </b></li>
                            <li class="py-1"><span class="mr-2 fas fa-check text-success"></span> Customer support</li>
                        </ul>
                    </div>
                    @endif




                </div>
            </div>

            @endforeach

       
            
            
            @if(user()->subscription()->change_to_free_plan !== null)
            <div class="col-12  text-center justify-content-center">
                <div class="col-lg-12">
                    <h6 class="mt-5 pb-xl-3">Your plan will end on {{ $subscription->change_to_free_plan->format('F d, Y') }}</h6>
                </div>
            </div>
            @elseif(user()->subscription()->plan->isFree())
            <p></p>
            @else
            <div class="col-12  text-center justify-content-center">
                <div class="col-lg-12">
                    <h6 class="mt-5 pb-xl-3">Your plan will renew on {{ $valid_until->format('F d, Y') }}</h6>
                    <p class="fs-1">
                        <a class="text-decoration small cancel-plan" data-toggle="modal" data-target="#cancel_subscription">Cancel My Plan</a>
                    </p>
                </div>
            </div> 

            @include('frontend.includes.modals.confirm_cancel_subscription')
            @endif




        </div>
    </div>

</div>

<div id="boxmobile" class="row justify-content-center">



    <div class="row col-lg-8 col-xl-7 col-xxl-6 pb-xl-6 pt-xl-6">
        <h5 id="mobiletitles" class="mb-0 pb-xl-4 text-left font-weight-bold">   Every premium plan comes with:</h5>
        <div class="col-lg-6">
<!-- <i class="fas fa-poll-h"></i> Font Awesome fontawesome.com -->
            <div id="boxaboutplanincluds">
                <h5 class="fs-m-3 font-weight-bold"><i class="fas fa-stream mr-xl-3" style="width: 36px;
                                                       height: 36px;"></i>Unlimited searches</h5>
                <p class="fs-m-2">Our database of Spotify playlist curators exceeds 10,000 making it the largest in the world.</p></div>
            <div id="boxaboutplanincluds">
                <h5 class="fs-m-3 font-weight-bold"><i class="fas fa-magic mr-xl-3" style="width: 36px;
                                                       height: 36px;"></i>Pitching email templates</h5>
                <p class="fs-m-2">Use our customizable templates to boost your open rate, create valuable connections, and get accepted to your ideal playlists.</p></div></div>
        <div class="col-lg-6">
            <div id="boxaboutplanincluds">
                <h5 class="fs-m-3 font-weight-bold"><i class="fas fa-filter mr-xl-3" style="width: 36px;
                                                       height: 36px;"></i>Robust filters</h5>
                <p class="fs-m-2">Set search criteria so you only find playlist curators that are highly relevant to you..</p></div>
            <div id="boxaboutplanincluds">
                <h5 class="fs-m-3 font-weight-bold"><i class="fas fa-headset mr-xl-3" style="width: 36px;
                                                       height: 36px;"></i>Customer support</h5>
                <p class="fs-m-2">Our outstanding live chat support is available on working hours. Contact our customer support team 24/7 at support@PlaylistMap.com</p></div>
        </div>
    </div>
</div>


<div id="boxmobile" class="row justify-content-center">

    <div class="row col-lg-8 col-xl-7 col-xxl-6 pb-xl-6 pt-xl-6">

        <h5 id="mobiletitles" class="mb-0 pb-xl-4 text-left font-weight-bold">FAQs</h5>

        <div class="accordion " id="accordionExample">
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingOne"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">What is a credit?</span></button></div>
                <div class="collapse" id="collapseOne" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox">A credit is the currency you use to unlock a Spotify playlist curator’s contact information on our platform. One credit gets you one unlock. Each of our plans offers a different amount of credits. With more credits, you’ll have more opportunities to get in touch with relevant curators, introduce them to your music, and get added to their playlists.</div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingTwo"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">What happens if I use a credit but the playlist curator contact information is no good?</span></button></div>
                <div class="collapse" id="collapseTwo" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox" >We do our best to verify every Spotify playlist curator’s contact information, but in the event that it’s wrong, let us know by clicking the “report” button on the “My Unlocks” section on your profile, and we will check it out. If the contact information is fake or incorrect, we will refund your credit. </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingThree"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">How often do you update the catalog of playlist curators?</span></button></div>
                <div class="collapse" id="collapseThree" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox" >We automatically update our catalog daily. Every time we update it, we add more and more playlists and make sure the information for our current ones are up-to-date. With more than 12,500 playlists already on our catalog, PlaylistMap has more curator contacts than any of our competitors. 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingFour"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">What if a Spotify playlist curator asks for money?</span></button></div>
                <div class="collapse" id="collapseFour" aria-labelledby="headingFour" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox" >Never pay a curator in exchange for getting added to their playlist. We know it’s tempting, but trust us, don’t do it. If you do, you’ll be in violation of Spotify’s policies , which could lead you to getting kicked off their platform. Or, the playlist might get taken down. Technically, Spotify playlist curators are allowed to accept payments for listening to songs, as long as they don’t “sell” spots on their playlists.
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingFive"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">What if I don’t use up all of my credits by the end of the month?</span></button></div>
                <div class="collapse" id="collapseFive" aria-labelledby="headingFive" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox" >If you don’t use all of your credits, then you’re not pitching enough! For the best results, use all of the credits you pay for — this will increase your chances of getting included on your ideal playlists. At the end of each month, any remaining credits will roll over to the next month. If you decide to cancel your subscription, you can use your remaining credits until the end of the last paid month.
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-none border-bottom">
                <div class="card-header p-0" id="headingSix"><button class="btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix"><span class="fas fa-caret-right accordion-icon mr-3" data-fa-transform="shrink-2"></span><span class="fw-medium font-sans-serif text-900">When to send?</span></button></div>
                <div class="collapse" id="collapseSix" aria-labelledby="headingSix" data-parent="#accordionExample">
                    <div class="card-body pt-2">
                        <div class="pl-0 text-left"   id="texttipbox" >Be conscious of the time. Will the email reach the curator’s inbox in the middle of the night? Will it get buried in the morning rush? The best times to send an email is around 10 a.m.
                        </div>
                    </div>
                </div>
            </div>
        </div></div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center text-center ">
        <div class="justify-content-around px-3 ">
            <div class="d-flex flex-sm-row flex-column">
                <div class="mr-auto card px-0 mx-3 col-sm mb-3" style="    background: transparent;
                     box-shadow: none;
                     border: 1px solid #00000014;">
                    <img alt="" class="card-img-top" src="{{ asset('/frontend/img/yarden2.webp') }}" alt="...">
                    <div class="card-body">
                        <p class="card-text text-left">
                            <i id="quoteicon" class="fas fa-quote-left mb-xl-4" style="color: #2ac4fe;display: list-item;" ></i>
                            PlaylistMap is a must-have tool for every artist. <b>It saved me so much valuable time</b>, and put me in touch with so many playlist curators. For me it's an essential part of every new release campaign. </p>  
                        <div class="ml-3 align-self-center text-left lh-1 text-black">
                            <p class="mb-1 card-text"><small><strong>Yarden Saxophone</strong></small>  <img alt="" class="w-16 h-16" src="{{ asset('/frontend/img/verif.webp') }}" style="width: 16px;" alt="..."></p>
                            <p class="mb-1 card-text"><small>Artist</small></p>

                        </div>
                    </div>

                </div>
                <div class="mr-auto card px-0 mx-3 col-sm mb-3" style="    background: transparent;
                     box-shadow: none;
                     border: 1px solid #00000014;">
                    <img alt="" class="card-img-top" src="{{ asset('/frontend/img/amy-2.webp') }}" alt="...">
                    <div class="card-body">
                        <p class="card-text text-left">
                            <i id="quoteicon" class="fas fa-quote-left mb-xl-4" style="color: #2ac4fe;display: list-item;" ></i>
                            After only one day of using PlaylistMap <strong>I already got into 2 playlists that have in total 9,000 followers.</strong> I strongly recommend anyone who wants to promote their music organically to use this great platform.</p>
                        <div class="ml-3 align-self-center text-left lh-1 text-black">
                            <p class="mb-1 card-text"><small><strong>Amy Miyaro</strong></small></p>
                            <p class="mb-1 card-text"><small>Music Producer</small></p>

                        </div>
                    </div>

                </div>

                <div class="card px-0 mx-3 col-sm" style="    background: transparent;
                     box-shadow: none;
                     border: 1px solid #00000014;">
                    <img alt="" class="card-img-top" src="{{ asset('/frontend/img/ronny2.webp') }}" alt="...">
                    <div class="card-body">
                        <p class="card-text text-left">
                            <i id="quoteicon" class="fas fa-quote-left mb-xl-4" style="color: #2ac4fe;display: list-item;" ></i>
                            I mean, <strong>this is crazy man</strong>, I could search for hours for a good playlist and sometimes it took even longer to find their contact info, but now it's all in front of you!</p>
                        <div class="ml-3 align-self-center text-left lh-1 text-black">
                            <p class="mb-1 card-text"><small><strong>Ronny</strong></small></p>
                            <p class="mb-1 card-text"><small>Artist</small></p>
                        </div>
                    </div>

                </div>

            </div></div>
    </div></div>

@include('frontend.includes.modals.pay_now')
@endsection

@section('scripts')
<script>
    let stripe_key = "{{ config('services.stripe.key') }}";
</script>
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(function () {
        $('.buyNow').click(function () {
            let planId = $(this).data('plan-id');
            let paypalPlanID = $(this).data('pp-id');
            $('#plan_id').val(planId);
            $('#paypal-plan').val(paypalPlanID);
            $('#paymentModal').modal('show');
        });
    });
</script>
@endsection

<style>
    #top,.navbar-top,body
    {background: white !important;}


    @media (max-width: 767px) 
    {
        #boxmobile
        {margin-bottom: 16%;}
        #mobiletitles
        {
            padding-bottom: 10%;
            font-size: 26px;
        }
        div#boxaboutplanincluds
        {    padding: 5%;
             display: block;}
        #quoteicon
        {
            margin-bottom: 7%;
        }
    }  
    div#boxaboutplanincluds  > h5
    {    padding-bottom: 4%;}

    #boxaboutplanincluds > h5 > svg
    {    margin-right: 5%;}
</style>