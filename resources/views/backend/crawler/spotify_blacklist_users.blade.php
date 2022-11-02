@extends('backend.layouts.master')

@section('title', 'Spotify Blacklist')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Spotify Blacklist</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
@if($errors->any())
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">Spotify Blacklist List ({{ \App\Models\SpotifyBlacklistUsers::count() }})</h3>
        <div class="block-options">
            <div class="d-inline-block mr-3">@include('backend.includes.paritals.search', ['route' => route('backend.crawler.spotify_blacklist_users')])</div>
            <!--<button data-toggle="modal" data-target="#import_from_csv" class="btn-block-option " title="Import Playlists">
                <i class="fal fa-upload"></i></button>
            <a href="{{ route('backend.playlists.export') }}" class="btn-block-option " title="Export Playlists">
                <i class="fal fa-download"></i></a>-->
        </div>
    </div>
    @include('backend.includes.modals.import')
    <div class="block-content">
        <div class="table-responsive">
            <table class="table table-striped table-vcenter">
                <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Spotify User ID</th>
                        <th>Updated ON</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spotifyBlacklistUsers as $spotifyBlacklistUser)
                    <tr>
                        <td>{{ $spotifyBlacklistUser->id }}</td>
                        <td>{{ $spotifyBlacklistUser->spotify_user_id}}</td>
                        <td><x-friendly-date :date="$spotifyBlacklistUser->updated_at"/></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a data-id="{{$spotifyBlacklistUser->id}}" data-label="{{$spotifyBlacklistUser->spotify_user_id}}" class="btn btn-sm btn-danger move-user-to-whitelist"
                           data-toggle="tooltip" title="Move User To Whitelist">
                            <i class="fal fa-trash-alt pe-none text-white"></i>
                        </a>
                    </div>
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination justify-content-center">
                {{ $spotifyBlacklistUsers->links() }}
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script> var homeurl = "{{ url('/')}}";</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/backend.js'). "?v=" .  config('constants.assets_version') }}"></script>  

@endsection