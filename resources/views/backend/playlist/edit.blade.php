@extends('backend.playlist.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Playlists</a>
@endsection
@section('breadcrumb-active', 'Update')

@section('form-heading', 'Update Playlist')

@section('route', route('backend.playlists.update', $playlist->id))

@section('form-fields')
    @method('put')
    @include('backend.playlist.fields')
@endsection
