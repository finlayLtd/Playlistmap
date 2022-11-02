@extends('backend.playlist.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Playlists</a>
@endsection
@section('breadcrumb-active', 'Create')

@section('form-heading', 'Add Playlist')

@section('route', route('backend.playlists.store'))

@section('form-fields')
    @include('backend.playlist.fields')
@endsection
