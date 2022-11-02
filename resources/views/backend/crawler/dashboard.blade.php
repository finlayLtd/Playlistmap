@extends('backend.layouts.master')

@section('title', 'Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Playlists Crawler</a>
@endsection
@section('breadcrumb-active', 'Dashboard')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h1 class="text-center11">Crawler Statistics Updated- {{$statisticsTime}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h2>Playlists statuses</h2>
        @foreach ($playlistsCrawler as $playlistCrawler)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 @if($playlistCrawler['status'] === "Total") font-weight-bold list-group-item-info @endif">{{ucwords(str_replace('-', ' ',$playlistCrawler['status'] ))}}</li>

            @if($playlistCrawler['status'] === "Total")
            <li class="list-group-item col-md-6 font-weight-bold list-group-item-info">{{number_format($playlistCrawler['total'])}}</li>
            @else
            <li class="list-group-item col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {{number_format($playlistCrawler['total'])}}

                    </div>
                    <div class="col-md-6 font-weight-bold">
                        {{number_format($playlistCrawler['percent'], 1)}}%
                    </div>
                </div>
            </li>
            @endif
        </ul>
        @endforeach


        <h2 class="mt-20">Playlists Source</h2>
        @foreach ($playlistsSource as $playlistSource)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6">{{$playlistSource['label']}}</li>
            <li class="list-group-item col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {{number_format($playlistSource['value'])}}

                    </div>
                    <div class="col-md-6 font-weight-bold">
                        {{number_format($playlistSource['percent'], 1)}}%
                    </div>
                </div>
            </li>
        </ul>
        @endforeach


        <h2 class="mt-20">Validity rate</h2>
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 font-weight-bold list-group-item-info">Validity rate</li>
            <li class="list-group-item col-md-6 font-weight-bold list-group-item-info">{{number_format($validityRate, 2, '.', ',')}}%</li>
        </ul>

        <h2 class="mt-20">Modules last time run</h2>
        <div class="row border border-primary p-5">

            @foreach ($lastTimeModulesRun as $lastTimeModuleRun)
            <div class="col-md-4">
                <label for="exampleInputEmail1">{{$lastTimeModuleRun['label']}}</label>
                <div class="alert alert-{{$lastTimeModuleRun['color']}}" role="alert">
                    {{$lastTimeModuleRun['value']}}
                </div>
            </div>

            @endforeach
        </div>


    </div>
    <div class="col-md-4">
        <h2>Playlists slugs</h2>
        @foreach ($playlistsCrawlerSlugs as $playlistsCrawlerSlug)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 @if($playlistsCrawlerSlug['removal_slug'] === "Total") font-weight-bold list-group-item-info @endif)">{{ucwords(str_replace('-', ' ',$playlistsCrawlerSlug['removal_slug'] ))}}</li>
            @if($playlistsCrawlerSlug['removal_slug'] === "Total")
            <li class="list-group-item col-md-6 font-weight-bold list-group-item-info">{{number_format($playlistsCrawlerSlug['total'])}}</li>
            @else
            <li class="list-group-item col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {{number_format($playlistsCrawlerSlug['total'])}}

                    </div>
                    <div class="col-md-6 font-weight-bold">
                        {{number_format($playlistsCrawlerSlug['percent'], 1)}}%
                    </div>
                </div>
            </li>
            @endif
        </ul>
        @endforeach

        @if(isset($crawlerUsersModule))
        <h2 class="mt-20">Crawler Users Module</h2>
        @foreach ($crawlerUsersModule as $item)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 @if(!isset($item['percent'])) font-weight-bold list-group-item-info @endif">{{$item['label']}}</li>
            <li class="list-group-item col-md-6 @if(!isset($item['percent'])) font-weight-bold list-group-item-info @endif">
                <div class="row">
                    <div class="col-md-6">
                        {{number_format($item['value'])}}

                    </div>
                    @if(isset($item['percent']))
                    <div class="col-md-6 font-weight-bold">
                        {{number_format($item['percent'], 1)}}%
                    </div>
                    @endif
                </div>
            </li>
        </ul>
        @endforeach
        @endif

    </div>
    <div class="col-md-4">
        <h2>New Playlists Statistics</h2>
        @foreach ($playlistsCrawlerStatistics as $key => $value)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 @if($key === "Total") font-weight-bold list-group-item-info @endif)">{{$key}}</li>
            <li class="list-group-item col-md-6 @if($key === "Total") font-weight-bold list-group-item-info @endif)">{{number_format($value)}}</li>
        </ul>
        @endforeach

        <h2 class="mt-20">Playlists Users Statuses</h2>
        @foreach ($spotifyUsersPlaylists as $spotifyUsersPlaylist)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6 @if($spotifyUsersPlaylist['status'] === "Total" || $spotifyUsersPlaylist['status'] === "Success Rate") font-weight-bold list-group-item-info @endif">{{ucwords(str_replace('-', ' ',$spotifyUsersPlaylist['status'] ))}}</li>
            <li class="list-group-item col-md-6 @if($spotifyUsersPlaylist['status'] === "Total" || $spotifyUsersPlaylist['status'] === "Success Rate") font-weight-bold list-group-item-info @endif">
                @if($spotifyUsersPlaylist['status'] === "Success Rate")
                {{number_format($spotifyUsersPlaylist['total'], 1)}}%
                @else
                {{number_format($spotifyUsersPlaylist['total'])}}
                @endif
            </li>
        </ul>
        @endforeach


        <h2 class="mt-20">Crawler Words Module Statistics</h2>
        @foreach ($playlistCrawlerWordsStatistics as $key => $value)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6">{{$key}}</li>
            <li class="list-group-item col-md-6">{{number_format($value)}}</li>
        </ul>
        @endforeach 

        <h2 class="mt-20">Spotify Users</h2>
        @foreach ($spotifyUsers as $key => $value)
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-6">{{$key}}</li>
            <li class="list-group-item col-md-6">{{number_format($value)}}</li>
        </ul>
        @endforeach

    </div>
</div>
@endsection