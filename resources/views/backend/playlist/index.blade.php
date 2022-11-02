@extends('backend.layouts.master')

@section('title', 'Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Playlists</a>
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
        <h3 class="block-title">Playlists List ({{ \App\Models\Playlist::count() }})</h3>
        <div class="block-options">
            <div class="d-inline-block mr-3">@include('backend.includes.paritals.search', ['route' => route('backend.playlists.index')])</div>
            <button data-toggle="modal" data-target="#import_from_csv" class="btn-block-option " title="Import Playlists">
                <i class="fal fa-upload"></i></button>
            <a href="{{ route('backend.playlists.export') }}" class="btn-block-option " title="Export Playlists">
                <i class="fal fa-download"></i></a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Uploaded On</th>
                        <th>Followers</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($playlists as $playlist)
                    <tr>
                        <td>{{ $playlist->id }}</td>
                        <td>{{ $playlist->playlist_id }}</td>
                        <td>{{ $playlist->name }}</td>
                        <td>
                            @foreach($playlist->contacts as $contact)
                            <span class=" mr-2">{{ $contact }}</span>
                            @endforeach
                        </td>
                        <td><x-friendly-date :date="$playlist->created_at"/></td>
                <td>{{ $playlist->followers }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('backend.playlists.show', $playlist->id) }}" class="btn btn-sm btn-primary"
                           data-toggle="tooltip" title="View">
                            <i class="fal fa-eye"></i>
                        </a>
                        <a href="{{ route('backend.playlists.edit', $playlist->id) }}" class="btn btn-sm btn-secondary"
                           data-toggle="tooltip" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>

                        <button data-toggle="modal" data-target="#confirm_playlist_{{$playlist->id}}" class="btn btn-sm btn-outline-danger" title="">
                            <i class="fa fa-trash"></i></button>
                        @include('backend.includes.modals.confirm', ['model' => 'playlist', 'route' => route('backend.playlists.destroy', $playlist->id), 'form' => true])
                    </div>
                </td>
                </tr>
                @empty
                <tr>
                    <td colspan="999" class="text-center">{{ config('constants.no_record') }}</td>
                </tr>
                @endforelse
                </tbody>
            </table>

            <div class="pagination justify-content-center">
                {{ $playlists->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
