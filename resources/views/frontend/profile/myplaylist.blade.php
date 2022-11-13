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
</div>
@endsection