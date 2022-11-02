@extends('backend.layouts.master')

@section('title', 'Crawler Words')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Crawler Words</a>
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
        <h3 class="block-title">Words List ({{ \App\Models\PlaylistCrawlerWord::count() }})</h3>
        <div class="block-options">
            <div class="d-inline-block mr-3">@include('backend.includes.paritals.search', ['route' => route('backend.crawler.words')])</div>
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
                        <th>Query</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Total New Words</th>
                        <th>Total New Playlists</th>
                        <th>Updated ON</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($playlistsCrawlerWords as $word)
                    <tr>
                        <td>{{ $word->id }}</td>
                        <td>{{ $word->query }}</td>
                        <td>{{ $word->status }}</td>
                        <td>{{ $word->priority }}</td>
                        <td>{{ $word->total_new_words }}</td>
                        <td>{{ $word->total_new_playlists }}</td>
                        <td><x-friendly-date :date="$word->updated_at"/></td>
                        <td>{{ $word->comments}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pagination justify-content-center">
                {{ $playlistsCrawlerWords->links() }}
            </div>
        </div>

    </div>
</div>
@endsection
