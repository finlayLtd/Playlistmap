@extends('layouts.frontend')

@section('content')
<section>
    <div class="wrap">
        <div class="col-md-6">
            <h4>Song</h4>
            <div class="d-flex">
                <div class="image-wrapper">
                    @if($userImage)
                    <img alt="" src="{{$userImage}}" />
                    @endif
                </div>
                <div class="d-flex flex-column">
                    <div class="song-name">Amor Fati</div>
                    <div class="artist-details">
                        @if($userImage)
                        <img alt="" src="{{$userImage}}" />
                        @endif
                        <h5>Goldian</h5>
                    </div>
                </div>
            </div>
            <div class="genres d-flex">
                <div class="me-3">Genres</div> 
                <div class="me-3">edm</div>
                <div class="me-3">edm1</div>
                <div class="me-3">edm2</div>
                <div class="me-3">edm3</div>
            </div>

            <div class="song-wrapper" data-id="7HG0rqokbOpSPNcKT1zMBe"></div>
            
            
            <iframe src="https://open.spotify.com/embed/playlist/37i9dQZF1E39JZqHiCVJO9?utm_source=generator" width="100%" height="380" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
        </div>
        <div class="col-md-6"></div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://sdk.scdn.co/spotify-player.js"></script>
<script>
$(function () {
    console.log('ready');

    window.onSpotifyWebPlaybackSDKReady = () => {
//        const token = '<?php echo $accessToken; ?>';
        const player = new Spotify.Player({
            name: 'Web Playback SDK Quick Start Player',
            getOAuthToken: cb => {
                cb('');
            },
            volume: 0.5
        });

        // Ready
        player.addListener('ready', ({ device_id }) => {
            console.log('Ready with Device ID', device_id);
        });

        // Not Ready
        player.addListener('not_ready', ({ device_id }) => {
            console.log('Device ID has gone offline', device_id);
        });

        player.addListener('initialization_error', ({ message }) => {
            console.error(message);
        });

        player.addListener('authentication_error', ({ message }) => {
            console.error(message);
        });

        player.addListener('account_error', ({ message }) => {
            console.error(message);
        });

//        document.getElementById('togglePlay').onclick = function () {
//            player.togglePlay();
//        };

        player.connect();
    }

})();



</script>

@endsection