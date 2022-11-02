@extends('backend.layouts.master')

@section('title', 'Spotify Users')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Spotify Users</a>
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
        <h3 class="block-title">Spotify Users List ({{ \App\Models\SpotifyUsers::count() }})</h3>

        <div class="block-options">
            <div class="d-inline-block mr-3">@include('backend.includes.paritals.search', ['route' => route('backend.crawler.spotify_users')])</div>
            <!--<button data-toggle="modal" data-target="#import_from_csv" class="btn-block-option " title="Import Playlists">
                <i class="fal fa-upload"></i></button>
            <a href="{{ route('backend.playlists.export') }}" class="btn-block-option " title="Export Playlists">
                <i class="fal fa-download"></i></a> -->
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
                        <th>Status</th>
                        <th>Total New Playlists</th>
                        <th>Updated ON</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($spotifyUsers as $spotifyUser)
                    <tr>
                        <td>{{ $spotifyUser->id }}</td>
                        <td>{{ $spotifyUser->spotify_user_id}}</td>
                        <td>{{ $spotifyUser->status}}</td>
                        <td>{{ $spotifyUser->total_playlists}}</td>
                        <td><x-friendly-date :date="$spotifyUser->updated_at"/></td>
                <td class="text-center">
                    <div class="btn-group">
                        <a data-id="{{$spotifyUser->id}}" data-label="{{$spotifyUser->spotify_user_id}}" class="btn btn-sm btn-danger move-user-to-blacklist"
                           data-toggle="tooltip" title="Move User To Blacklist">
                            <i class="fal fa-trash-alt pe-none text-white"></i>
                        </a>
                    </div>
                </td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination justify-content-center">
                {{ $spotifyUsers->links() }}
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