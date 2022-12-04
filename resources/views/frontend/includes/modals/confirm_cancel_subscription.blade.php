<div class="modal fade" id="cancel_subscription" tabindex="-1" aria-labelledby="cancel_subscription"
     aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
            </div>
            <div class="modal-body">
                <form action="{{ route('frontend.subscription.cancel') }}" method="post">
                    @csrf
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    We'll miss you, {{ user()->name  ?? ""}}
                                </p>
                            </div>
                            <div class="col-12 cancel-plan-radois-wrapper">
                                <label for="exampleFormControlInput1" class="form-label font-weight-bold">Let us know why you're cancelling:</label>
                                <div class="form-check">

                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cancelation_reason" id="cancelation-reason" value="I'm not releasing new music soon">I'm not releasing new music soon
                                    </label>
                                </div>
                                <div class="form-check">

                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cancelation_reason" id="cancelation-reason" value="I didn't get any placements">I didn't get any placements
                                    </label>
                                </div>
                                <div class="form-check">

                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cancelation_reason" id="cancelation-reason" value="I'm using other promotion services">I'm using other promotion services
                                    </label>
                                </div>
                                <div class="form-check">

                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="cancelation_reason" id="cancelation-reason" value="It's too expensive">It's too expensive
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" value="Other" name="cancelation_reason" id="cancelation-reason">Other (please specify):
                                    </label>
                                </div>
                                <div class="cancelation-reason-other-wrapper invisible">
                                    <input type="text" class="form-control" id="cancelation-reason-other-input" name="cancelation_reason_other" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="text-center">
                        <button class="btn btn-sm btn-primary confirmUnlock" disabled>Cancel My Subscription</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal" aria-label="Close">
                            I changed my mind
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
