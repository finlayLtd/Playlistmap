<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content position-relative">
            <div class="position-absolute" data-dismiss="modal" aria-label="Close" style="cursor:pointer">
                <i class="fas fa-times" style="font-size:25px;"></i>
            </div>
            <img alt="" class="loader" src="{{asset('images/icons/loader-white.gif')}}" />
            <div class="modal-header border-0 pb-0">
                <img alt="" class="mr-2" src="{{ asset('images/logo-w.webp') }}"  width="190" />
            </div>
            <div class="modal-body">
                <div class="monthly-yearly-wrapper d-flex align-items-center justify-center month small">
                    <div class="text pe-2 month">Pay Monthly</div>
                    @include('frontend.components.forms.toggle', ['name' => 'yearly-monthly-toggle-modal', 'id' => 'yearly-monthly-toggle-modal'])   
                    <div class="text ps-2 year">Pay Yearly & Save <span class="green-color">20%</span></div>
                </div>

                <div id="modal-plan-details row" class="plan-details d-flex justify-content-between" data-month-plan-id="" data-month-plan-pp-id="" data-year-plan-id="" data-year-plan-pp-id="">
                    <div class="col-6 plan-info d-flex flex-column text-center">
                        <h5 class="text-center"><span class="plan-name"></span> Plan</h5>
                        <div class="plan-sd gap-1 mt-2 align-items-center d-flex justify-content-center"><span id="credit_count"></span> Credits/Month
                            <span data-toggle="tooltip" data-placement="right" title="A credit is the currency you use to unlock a Spotify playlist curator’s contact information on our platform. One credit gets you one unlock.">
                                <i class="fa-solid fa-circle-info secondary-color"></i>
                            </span>
                        </div>
                    </div>
                    <div class="plan-price col-6">
                        <h4 style="margin:0;">
                            <span class="normal-price">
                                $<span id="modal-plan-price-year"></span><span id="modal-plan-price-month"></span><sup class="tertiary-color">  /Month</sup>
                            </span>
                            <span class="coupon-price">
                                $<span id="modal-plan-price-year-coupon"></span><span id="modal-plan-price-month-coupon"></span><sup class="tertiary-color">/Month</sup>
                            </span>
                        </h4>
                        <div class="yearly-plan-save tertiary-color d-flex align-items-center">$<span id="modal-year-price">143.88</span>/year <span class="ms-2 px-3 save green-color green-background text-truncate">Save $<span id="modal-yearly-save"></span></span></div>
                    </div>
                </div>

                @if(!user()->subscription()->stripe_id && !user()->subscription()->paypal_id)


                <ul class="nav nav-tabs" id="payment-nav-tabs" role="tablist">
                    <li class="nav-item w-100" role="presentation">
                        <button class="nav-link payment-button-tab mx-auto text-center active" data-target="#stripe-wrapper" type="button" role="tab" aria-selected="false">
                            <i class="fa-thin fa-credit-card-blank"></i> Credit Card
                        </button>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <button class="nav-link payment-button-tab mx-auto text-center" data-target="#paypal-wrapper" type="button" role="tab" aria-selected="false">
                            <i class="fa-brands fa-paypal"></i> Paypal
                        </button>
                    </li> -->
                </ul>
                @endif
                <div class="tab-content">
                    <div id="stripe-wrapper" class="tab-pane stripe-wrapper @if( (!user()->subscription()->stripe_id && !user()->subscription()->paypal_id) || (user()->subscription()->stripe_id && !user()->subscription()->paypal_id)) active @endif">
                        <form action="{{ route('frontend.subscription.checkout') }}" id="stripe_form" method="post">
                            @csrf
                            <input type="hidden" name="plan_id" id="plan_id">
                            <input type="hidden" name="coupon-code" id="coupon-code">
                            <input type="coupon" class="form-control" id="coupon" value="{{$coupon ?? ""}}">
                                        
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                <label class="form-check-label" for="flexCheckChecked" style="cursor:pointer">
                                    I agree to the <a href="/terms" target="_blank">Terms & Conditions</a> and <a href="/privacy" target="_blank">Privacy Policy</a>
                                </label>
                            </div>

                            <div class="mt-3">
                                <button onclick="return true;" type="submit" class="primary place-order-button d-flex justify-content-center" data-toggle="modal" data-target="#loader" data-dismiss="modal" aria-label="Close" id="pay_now">
                                    <i class="fa-thin fa-credit-card-blank"></i> Subscribe & Pay $<span id="pay-button-amount-month"></span><span id="pay-button-amount-year"></span>
                                </button>
                            </div>
                        </form>
                        <div class="authorize mt-32 mb-32">
                            I authorize PlaylistMap to save this payment method and automatically charge this payment method whenever a subscription is associated with it.
                        </div>

                        <div class="powered-by-stripe fs-small">
                            Powered by <i class="fab fa-stripe powered-by-stripe-icon"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
