@extends('layouts.frontend-main')

@section('content')
<div>
    <div class="container" style="padding-top:70px">
        <h4>My Playlists</h4>
        <div class="float-right"> </div>
    </div>
    <div class="container row">
        @include('frontend.includes.partials.gridlist', ['playlists'=>$playlists])
    </div>

    @if(method_exists($playlists, 'links'))
        <div style="line-height: 1;display:flex;" class="justify-content-center mt-5 pt-5">
            {{ $playlists->appends(request()->query())->onEachSide(0)->links() }}
        </div>
    @endif
</div>
@endsection