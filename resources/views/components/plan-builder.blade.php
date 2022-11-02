@props(['plan'])

<div class="col-md-6 col-xl-3">
    <div class="block shadow-sm block-rounded block-bordered">
        <div class="block-header">
            <h3 class="block-title font-w600 text-center">
                <div class="form-material pt-0">
                    <input type="hidden" name="plans[{{ $plan->id }}][id]" value="{{ $plan->id }}">
                    <input type="text" class="form-control form-control-sm" id="material-input-size-sm2"
                           name="plans[{{ $plan->id }}][name]" value="{{ $plan->name }}">
                </div>
            </h3>
        </div>

        <div class="block-content">
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox" id="plan_{{$plan->id}}_credit" disabled checked>
                    <label class="custom-control-label align-self-end" for="plan_{{$plan->id}}_credit">Credits</label>
                    <div class="form-material form-material-sm w-25 pt-0 ml-3">
                        <input type="text" class="form-control form-control-sm"
                               name="plans[{{ $plan->id }}][features][credits]"
                               value="{{$plan->getFeatureByName('credits')->value}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox"
                           name="plans[{{ $plan->id }}][features][message_builder]"
                           id="plan_{{$plan->id}}_message_builder" value="Y"
                        {{$plan->getFeatureByName('message_builder')->value == 'Y' ? 'checked' : ''}} >
                    <label class="custom-control-label" for="plan_{{$plan->id}}_message_builder">Message Builder</label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox" id="plan_{{$plan->id}}_templates" disabled checked>
                    <label class="custom-control-label" for="plan_{{$plan->id}}_templates">Dynamic Templates</label>
                    <div class="form-material form-material-sm w-25 pt-0 ml-3">
                        <input type="text" class="form-control form-control-sm"
                               name="plans[{{ $plan->id }}][features][dynamic_templates]"
                               value="{{$plan->getFeatureByName('dynamic_templates')->value}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox" id="plan_{{$plan->id}}_price" disabled checked>
                    <label class="custom-control-label" for="plan_{{$plan->id}}_price">Monthly Payment</label>
                    <div class="form-material form-material-sm w-25 pt-0 ml-3">
                        <input type="text" class="form-control form-control-sm" id="material-input-size-sm2"
                               name="plans[{{ $plan->id }}][price]" value="{{ $plan->price }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox"
                           name="plans[{{ $plan->id }}][features][exclusive_playlists]"
                           id="plan_{{$plan->id}}_exclusive" value="Y"
                        {{$plan->getFeatureByName('exclusive_playlists')->value == 'Y' ? 'checked' : ''}}>
                    <label class="custom-control-label" for="plan_{{$plan->id}}_exclusive">Exclusive Playlists</label>
                </div>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline mb-5">
                    <input class="custom-control-input" type="checkbox" id="plan_{{$plan->id}}_search_limit"
                           value="1" checked disabled>
                    <label class="custom-control-label" for="plan_{{$plan->id}}_search_limit">Search Limit</label>
                    <div class="form-material form-material-sm w-25 pt-0 ml-3">
                        <input type="text" class="form-control form-control-sm"
                               value="{{$plan->getFeatureByName('search_limit')->value}}"
                               name="plans[{{ $plan->id }}][features][search_limit]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
