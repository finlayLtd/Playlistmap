<div class="trusted-by @if(isset($position) && $position === "center") secondary-color @endif">
    @if(isset($position) && $position === "center")
    <h5 class="text-center">Trusted by</h5>
    <div class="d-flex justify-content-start align-items-center mt-3">
        @else
        <div class="d-flex justify-content-start align-items-center">
            <div class="text">
                <h5>Trusted by</h5>
            </div>
            @endif
            <ul class="d-flex m-0 partners">
                <li class="me-5">
                    <img src="{{asset('/images/icons/partners/ditto.svg')}}" />
                </li>
                <li class="me-5">
                    <img src="{{asset('/images/icons/partners/alteza.svg')}}" />
                </li>
                <li class="me-5">
                    <img src="{{asset('/images/icons/partners/weraveyou.svg')}}" />
                </li>
                <li class="me-5">
                    <img src="{{asset('/images/icons/partners/vini-vici.svg')}}" />
                </li>
                <li class="me-5">
                    <img src="{{asset('/images/icons/partners/fangage.svg')}}" />
                </li>
            </ul>
        </div>
    </div>

