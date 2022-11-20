<div class="self-modal modal fade" id="subscription_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:100000;">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content login-modal position-relative" style="height:100vh">
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-auto container row">
                    <div class="d-flex align-items-center p-0 mt-2" style="color:#C0C0C0">
                        <span style="cursor:pointer" data-dismiss="modal" aria-label="Close"><i class="me-2 text-white mobile-d fa-regular fa-chevron-left" width="20px" height="20px"></i></span> Subscription
                    </div>
                    <div class="text-left mt-5" style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;">
                        Subscription
                    </div>
                    <div style="padding: 16px; background: #181818; border-radius: 10px;margin-top:16px">
                        <div class="profile-plan d-flex align-items-center">
                            <div class="thLetter">
                                <span class="title-plan">{{$user->subscription()->plan->name}}</span> <span class="mobile-d-none">Plan</span>
                            </div>
                            <div class="thLetter">
                                Monthly
                            </div>
                            <div class="thLetter position-relative">
                                <span class="price-plan">${{ $user->subscription()->plan->price}}</span><span class="position-absolute" style="font-size:12px;color: #827F7F">/Month</span>
                            </div>
                            <div class="thLetter">
                                {{ $user->subscription()->plan->getFeatureByName('credits'.($user->subscription()->plan->id==1?'':'-'.($user->subscription()->plan->id-1)))->value}} Credits/Month <i class="fas fa-exclamation-circle" style="color: #C0C0C0;"></i>
                            </div>
                            <div class="thLetter d-flex">
                                <button type="button" class="w-100 btn btn-danger" style="background-color:red;margin-left: 10px; padding: 10px !important; border-radius: 25px !important; color: white; float:right; "> <i class="far fa-chevron-down"></i> Manage Plan</button>
                            </div>
                        </div>

                        <div style="margin-top:24px; color: rgba(192, 192, 192, 1);" class="@if($user->subscription()->plan->name == 'Free') d-none @endif">
                            The next payment is due on <span style="color: rgba(251, 222, 75, 1) !important;">{{date_format($user->subscription()->ends_at, "F d, Y")}}</span> . 
                        </div>
                    </div>

                    <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;margin-top:40px;" class="desc_manage">
                        Payment Methods
                        <div style="font-weight: 400;font-size: 16px;line-height: 24px;letter-spacing: -0.0044em;margin-top:16px">
                            Securely add or remove payment methods.
                            <button type="button" class="manage-plan btn btn-outline-secondary" style="margin-left: 10px; margin-top:16px; padding: 10px !important; border-radius: 25px !important; color: white; float:right;"> Manage Payments</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>