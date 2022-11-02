@extends('backend.layouts.master')

@section('title', 'Crawler Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Crawler Playlists</a>
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
        <h3 class="block-title">Playlists List ({{ \App\Models\PlaylistCrawler::count() }})</h3>
        <div class="block-options">
            <div class="d-inline-block mr-3">@include('backend.includes.paritals.search', ['route' => route('backend.crawler.index')])</div>
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
                        <th>Playlist ID</th>
                        <th>Status</th>
                        <th>Removal Slug</th>
                        <th>Removal Reason</th>
                        <th>Contacts</th>
                        <th>Spotify User ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($playlistsCrawler as $playlist)
                    <tr>
                        <td>{{ $playlist->id }}</td>
                        <td>{{ $playlist->spotify_id}}</td>
                        <td>{{ $playlist->status}}</td>
                        <td>{{ $playlist->removal_slug}}</td>
                        <td>{{ $playlist->removal_reason}}</td>
                        <td>
                            @if($playlist->contacts)
                            @foreach(json_decode($playlist->contacts) as $contact)
                            <span class=" mr-2">{{ $contact }}</span>
                            @endforeach
                            @endif
                        </td>
                        <td>{{ $playlist->spotify_user_id}}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="999" class="text-center">{{ config('constants.no_record') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="pagination justify-content-center">
                {{ $playlistsCrawler->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
