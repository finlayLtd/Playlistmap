
<script src="{{ asset('vendors/popper/popper.min.js') }}"></script>
<script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/anchorjs/anchor.min.js') }}"></script>
<script src="{{ asset('vendors/is/is.min.js') }}"></script>
<script src="{{ asset('vendors/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('vendors/progressbar/progressbar.min.js') }}"></script>
<script src="{{ asset('vendors/fontawesome6/all.min.js') }}"></script>
<!--<script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>-->
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>


<script src="{{ asset('vendors/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('vendors/swiper/swiper-bundle.min.js') }}"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
<script src="{{ asset('vendors/list.js/list.min.js') }}"></script>
<script src="{{ asset('frontend/js/theme.js') }}"></script>
<script src="{{asset('js/toastr.min.js')}}"></script>
{{asset('js/script.js')}}
<script src="{{asset('js/script.js'). "?v=" .  config('constants.assets_version') }}"></script>    
<script src="https://cdnjs.cloudflare.com/ajax/libs/timeago.js/2.0.2/timeago.min.js"></script>

<script>

    @php($notifications = array('error', 'success', 'warning', 'info'))
    @foreach($notifications as $notification)
        @if(session()->has($notification))
            {{ "toastr." . $notification }}{!! "('" !!}{{session()->get($notification)}}{!! "')" !!}
        @endif
    @endforeach

    @error('email')
        {{ "toastr.error" }}{!! "('" !!}{{$message."Please try again."}}{!! "')" !!}
    @endif
    @error('password')
        {{ "toastr.error" }}{!! "('" !!}{{$message."Please try again"}}{!! "')" !!}
    @endif

</script>

@yield('scripts')
<link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap"
    rel="stylesheet">

@include('frontend.includes.third-party.tawkto')
