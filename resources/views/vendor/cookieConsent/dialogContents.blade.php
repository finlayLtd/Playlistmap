<div class="js-cookie-consent cookie-consent">

    <div class="toast bg-white notice" role="alert"
         data-options='{"autoShow":true,"autoShowDelay":0,"showOnce":true}'
         data-autohide="false"
         aria-live="assertive" aria-atomic="true">
        <div class="toast-body d-lg-flex justify-content-center align-items-center text-center px-5">
            <span class="cookie-consent__message">
                <img class="mr-2" src="{{ asset('images/frontend/cookie.png') }}" width="20" alt="">
                {!! trans('cookieConsent::texts.message') !!}
            </span>

            <button class="btn btn-primary btn-sm ml-3 js-cookie-consent-agree cookie-consent__agree">
                {{ trans('cookieConsent::texts.agree') }}
            </button>
        </div>
    </div>

</div>
