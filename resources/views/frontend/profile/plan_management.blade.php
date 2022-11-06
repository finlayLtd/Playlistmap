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


                        <h5 class="font-weight-medium my-3">
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
                    <img class="card-img-top" src="{{ asset('/frontend/img/yarden2.png') }}" alt="...">
                    <div class="card-body">
                        <p class="card-text text-left">
                            <i id="quoteicon" class="fas fa-quote-left mb-xl-4" style="color: #2ac4fe;display: list-item;" ></i>
                            PlaylistMap is a must-have tool for every artist. <b>It saved me so much valuable time</b>, and put me in touch with so many playlist curators. For me it's an essential part of every new release campaign. </p>  
                        <div class="ml-3 align-self-center text-left lh-1 text-black">
                            <p class="mb-1 card-text"><small><strong>Yarden Saxophone</strong></small>  <img class="w-16 h-16" src="{{ asset('/frontend/img/verif.png') }}" style="width: 16px;" alt="..."></p>
                            <p class="mb-1 card-text"><small>Artist</small></p>

                        </div>
                    </div>

                </div>
                <div class="mr-auto card px-0 mx-3 col-sm mb-3" style="    background: transparent;
                     box-shadow: none;
                     border: 1px solid #00000014;">
                    <img class="card-img-top" src="{{ asset('/frontend/img/amy-2.png') }}" alt="...">
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
                    <img class="card-img-top" src="{{ asset('/frontend/img/ronny2.png') }}" alt="...">
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
<script src="{{ asset('js/stripe-input.js') }}"></script>
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


<script>
    var onlyOnKonami = false;
    $(function () {
        // Globals
        var $window = $(window)
                , random = Math.random
                , cos = Math.cos
                , sin = Math.sin
                , PI = Math.PI
                , PI2 = PI * 2
                , timer = undefined
                , frame = undefined
                , confetti = [];

        var runFor = 2000
        var isRunning = true

        setTimeout(() => {
            isRunning = false
        }, runFor);

        // Settings
        var konami = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65]
                , pointer = 0;

        var particles = 150
                , spread = 20
                , sizeMin = 5
                , sizeMax = 12 - sizeMin
                , eccentricity = 10
                , deviation = 100
                , dxThetaMin = -.1
                , dxThetaMax = -dxThetaMin - dxThetaMin
                , dyMin = .13
                , dyMax = .18
                , dThetaMin = .4
                , dThetaMax = .7 - dThetaMin;

        var colorThemes = [
            function () {
                return color(200 * random() | 0, 200 * random() | 0, 200 * random() | 0);
            }, function () {
                var black = 200 * random() | 0;
                return color(200, black, black);
            }, function () {
                var black = 200 * random() | 0;
                return color(black, 200, black);
            }, function () {
                var black = 200 * random() | 0;
                return color(black, black, 200);
            }, function () {
                return color(200, 100, 200 * random() | 0);
            }, function () {
                return color(200 * random() | 0, 200, 200);
            }, function () {
                var black = 256 * random() | 0;
                return color(black, black, black);
            }, function () {
                return colorThemes[random() < .5 ? 1 : 2]();
            }, function () {
                return colorThemes[random() < .5 ? 3 : 5]();
            }, function () {
                return colorThemes[random() < .5 ? 2 : 4]();
            }
        ];
        function color(r, g, b) {
            return 'rgb(' + r + ',' + g + ',' + b + ')';
        }

        // Cosine interpolation
        function interpolation(a, b, t) {
            return (1 - cos(PI * t)) / 2 * (b - a) + a;
        }

        // Create a 1D Maximal Poisson Disc over [0, 1]
        var radius = 1 / eccentricity, radius2 = radius + radius;
        function createPoisson() {
            // domain is the set of points which are still available to pick from
            // D = union{ [d_i, d_i+1] | i is even }
            var domain = [radius, 1 - radius], measure = 1 - radius2, spline = [0, 1];
            while (measure) {
                var dart = measure * random(), i, l, interval, a, b, c, d;

                // Find where dart lies
                for (i = 0, l = domain.length, measure = 0; i < l; i += 2) {
                    a = domain[i], b = domain[i + 1], interval = b - a;
                    if (dart < measure + interval) {
                        spline.push(dart += a - measure);
                        break;
                    }
                    measure += interval;
                }
                c = dart - radius, d = dart + radius;

                // Update the domain
                for (i = domain.length - 1; i > 0; i -= 2) {
                    l = i - 1, a = domain[l], b = domain[i];
                    // c---d          c---d  Do nothing
                    //   c-----d  c-----d    Move interior
                    //   c--------------d    Delete interval
                    //         c--d          Split interval
                    //       a------b
                    if (a >= c && a < d)
                        if (b > d)
                            domain[l] = d; // Move interior (Left case)
                        else
                            domain.splice(l, 2); // Delete interval
                    else if (a < c && b > c)
                        if (b <= d)
                            domain[i] = c; // Move interior (Right case)
                        else
                            domain.splice(i, 0, c, d); // Split interval
                }

                // Re-measure the domain
                for (i = 0, l = domain.length, measure = 0; i < l; i += 2)
                    measure += domain[i + 1] - domain[i];
            }

            return spline.sort();
        }

        // Create the overarching container
        var container = document.createElement('div');
        container.style.position = 'fixed';
        container.style.top = '0';
        container.style.left = '0';
        container.style.width = '100%';
        container.style.height = '0';
        container.style.overflow = 'visible';
        container.style.zIndex = '9999';

        // Confetto constructor
        function Confetto(theme) {
            this.frame = 0;
            this.outer = document.createElement('div');
            this.inner = document.createElement('div');
            this.outer.appendChild(this.inner);

            var outerStyle = this.outer.style, innerStyle = this.inner.style;
            outerStyle.position = 'absolute';
            outerStyle.width = (sizeMin + sizeMax * random()) + 'px';
            outerStyle.height = (sizeMin + sizeMax * random()) + 'px';
            innerStyle.width = '100%';
            innerStyle.height = '100%';
            innerStyle.backgroundColor = theme();

            outerStyle.perspective = '50px';
            outerStyle.transform = 'rotate(' + (360 * random()) + 'deg)';
            this.axis = 'rotate3D(' +
                    cos(360 * random()) + ',' +
                    cos(360 * random()) + ',0,';
            this.theta = 360 * random();
            this.dTheta = dThetaMin + dThetaMax * random();
            innerStyle.transform = this.axis + this.theta + 'deg)';

            this.x = $window.width() * random();
            this.y = -deviation;
            this.dx = sin(dxThetaMin + dxThetaMax * random());
            this.dy = dyMin + dyMax * random();
            outerStyle.left = this.x + 'px';
            outerStyle.top = this.y + 'px';

            // Create the periodic spline
            this.splineX = createPoisson();
            this.splineY = [];
            for (var i = 1, l = this.splineX.length - 1; i < l; ++i)
                this.splineY[i] = deviation * random();
            this.splineY[0] = this.splineY[l] = deviation * random();

            this.update = function (height, delta) {
                this.frame += delta;
                this.x += this.dx * delta;
                this.y += this.dy * delta;
                this.theta += this.dTheta * delta;

                // Compute spline and convert to polar
                var phi = this.frame % 7777 / 7777, i = 0, j = 1;
                while (phi >= this.splineX[j])
                    i = j++;
                var rho = interpolation(
                        this.splineY[i],
                        this.splineY[j],
                        (phi - this.splineX[i]) / (this.splineX[j] - this.splineX[i])
                        );
                phi *= PI2;

                outerStyle.left = this.x + rho * cos(phi) + 'px';
                outerStyle.top = this.y + rho * sin(phi) + 'px';
                innerStyle.transform = this.axis + this.theta + 'deg)';
                return this.y > height + deviation;
            };
        }


        function poof() {
            if (!frame) {
                // Append the container
                document.body.appendChild(container);

                // Add confetti

                var theme = colorThemes[onlyOnKonami ? colorThemes.length * random() | 0 : 0]
                        , count = 0;

                (function addConfetto() {

                    if (onlyOnKonami && ++count > particles)
                        return timer = undefined;

                    if (isRunning) {
                        var confetto = new Confetto(theme);
                        confetti.push(confetto);

                        container.appendChild(confetto.outer);
                        timer = setTimeout(addConfetto, spread * random());
                    }
                })(0);


                // Start the loop
                var prev = undefined;
                requestAnimationFrame(function loop(timestamp) {
                    var delta = prev ? timestamp - prev : 0;
                    prev = timestamp;
                    var height = $window.height();

                    for (var i = confetti.length - 1; i >= 0; --i) {
                        if (confetti[i].update(height, delta)) {
                            container.removeChild(confetti[i].outer);
                            confetti.splice(i, 1);
                        }
                    }

                    if (timer || confetti.length)
                        return frame = requestAnimationFrame(loop);

                    // Cleanup
                    document.body.removeChild(container);
                    frame = undefined;
                });
            }
        }

        $window.keydown(function (event) {
            pointer = konami[pointer] === event.which
                    ? pointer + 1
                    : +(event.which === konami[0]);
            if (pointer === konami.length) {
                pointer = 0;
                poof();
            }
        });

        if (true) {
            poof();
        }
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