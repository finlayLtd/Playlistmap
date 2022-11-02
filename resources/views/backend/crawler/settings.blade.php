@extends('backend.layouts.master')

@section('title', 'Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Playlists Crawler</a>
@endsection
@section('breadcrumb-active', 'Settings')

@section('content')
<h2>Words for playlists description:</h2>
<h5>If a specific word found in playlist description, it will not be added until manually review.</h5>

<div class="row mt-10">
    <div class="col-md-6">
        <form class="">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">Type new word:</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="new-word" value="">
                </div>
                <button id="add-new-word" class="btn btn-primary">Add Word</button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6 words-container">
        <h3>Current words:</h3>
        @foreach($words as $word)
        <span class="badge badge-primary" data-value="{{$word}}">{{$word}}</span>
        @endforeach
    </div>
</div>
<div class="row mt-5">
    <div class="col-md-4">
    <button id="add-new-word" class="btn btn-primary">Save changes</button>
    </div>
</div>
@endsection