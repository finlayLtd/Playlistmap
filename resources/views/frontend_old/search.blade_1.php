@extends('layouts.frontend')

@section('content')
<div class="card mb-3">
    <div id="searchheadtext" class="card-header bg-100">
        Search 
        <span data-toggle="tooltip" data-placement="right" title="You can search by entering an artist name, genre , or playlist name.">
            <i class="far fa-question-circle"></i>
        </span>
    </div>
    <div class="card-body py-5">
        <form class="" action="{{ route('frontend.search') }}">
            <div class="input-group w-75 mx-auto">
                <input class="form-control" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                    placeholder="Type Music Genres, Artists Names, Playlist Names"/>
                <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
            </div>
            <div class="mt-3 w-75 mx-auto text-center">
                @if(!request()->query('q') && $playlists->count() < 1)
                @foreach($keywords as $keyword)
                <span class="badge badge-soft-info">
                    <a class="hover-text-decoration-none"
                    href="{{ route('frontend.search', ['q' => $keyword->name]) }}">{{ $keyword->name }}</a>
                </span>
                @endforeach
                @endif
            </div>
        </form>
    </div>
</div>

@if(request()->query('q') && !$search_limit_exceeded)
<div class="card">
    <?php

    function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
                , $_SERVER["HTTP_USER_AGENT"]);
    }

    if (isMobileDevice()) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
For the best experience, use your computer <i class="fas fa-laptop"></i>
  <button style="background: none;
    border: none;
    position: absolute;
    right: 2%;
    top: 2%;
    font-size: 24px;" class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="font-weight-light" aria-hidden="true">×</span></button>
</div>';
    } else {
        echo "";
    }
    ?> 
    <div class="card-header bg-100">
        <b>{{ $results_count }}</b> results found for "<b>{{request()->query('q')}}</b>"
    </div>
    <div class="card-body">
        @if($playlists->count())
        @if(user()->subscription()->plan->isFree())
        <div class="alert alert-info text-center">
            <h3 class="text-center text-uppercase">Upgrade</h3>
            <p>
                Want to see more playlists? Upgrade your plan to unlock up to 100 playlists per month!
            </p>
            <a id="btnguestsearch" href="{{ route('frontend.profile.plans') }}" class="btn btn-sm btn-success">Upgrade
                Now</a>
        </div>
        @endif
        <div class="table-responsive">
            <table id="main-search-table" class="table border">
                <thead>
                    <tr class="">
                        @if(user()->subscription()->plan->isFree())
                        <th scope="col">Playlist Name</th>
                        <th scope="col">
                            <div class="title free tooltip-wrapper">
                                <span class="tooltiptext">Upgrade your plan to sort results</span>
                                Followers
                                @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                @svg('images/icons/down-arrow.svg', 'sort-arrow down')
                            </div>
                        </th>
                        <th scope="col">
                            <div class="title free tooltip-wrapper">
                                <span class="tooltiptext">Upgrade your plan to sort results</span>
                                Last Updated
                                @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                @svg('images/icons/down-arrow.svg', 'sort-arrow down')
                            </div>
                        </th>
                        <th scope="col">
                            <div class="title free tooltip-wrapper">
                                <span class="tooltiptext">Upgrade your plan to sort results</span>
                                Tracks
                                @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                @svg('images/icons/down-arrow.svg', 'sort-arrow down')
                            </div>
                        </th>
                        <th scope="col">Top Artists</th>
                        <th scope="col">Top Genres</th>
                        <th scope="col">Contact Details</th>

                        @else
                        <th scope="col">Playlist Name</th>
                        <th scope="col">
                            @if(request()->input('sortBy') && request()->input('sortBy') === 'followers')
                            <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'followers'])}}">
                                @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'followers')
                                <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'followers'])}}">
                                    @else
                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => 'followers', 'sortByAsc' => null])}}">
                                        @endif

                                        <div class="title 
                                             @if(request()->input('sortBy') && request()->input('sortBy') === 'followers')
                                             current-down
                                             @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'followers')
                                             current-up
                                             @endif
                                             ">
                                            Followers
                                            @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                            @svg('images/icons/down-arrow.svg', 'sort-arrow down')

                                        </div>
                                    </a></th>
                                    <th scope="col">

                                        @if(request()->input('sortBy') && request()->input('sortBy') === 'lastUpdated')
                                        <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'lastUpdated'])}}">
                                            @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'lastUpdated')
                                            <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'lastUpdated'])}}">
                                                @else
                                                <a href="{{request()->fullUrlWithQuery(['sortBy' => 'lastUpdated', 'sortByAsc' => null])}}">
                                                    @endif

                                                    <div class="title 
                                                         @if(request()->input('sortBy') && request()->input('sortBy') === 'lastUpdated')
                                                         current-down
                                                         @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'lastUpdated')
                                                         current-up
                                                         @endif
                                                         ">
                                                        Last Updated
                                                        @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                                        @svg('images/icons/down-arrow.svg', 'sort-arrow down')

                                                    </div>
                                                </a>
                                                </th>
                                                <th scope="col">
                                                    @if(request()->input('sortBy') && request()->input('sortBy') === 'tracks')
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'tracks'])}}">
                                                        @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'tracks')
                                                        <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'tracks'])}}">
                                                            @else
                                                            <a href="{{request()->fullUrlWithQuery(['sortBy' => 'tracks', 'sortByAsc' => null])}}">
                                                                @endif

                                                                <div class="title 
                                                                     @if(request()->input('sortBy') && request()->input('sortBy') === 'tracks')
                                                                     current-down
                                                                     @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'tracks')
                                                                     current-up
                                                                     @endif
                                                                     ">
                                                                    Tracks
                                                                    @svg('images/icons/up-arrow.svg', 'sort-arrow up')
                                                                    @svg('images/icons/down-arrow.svg', 'sort-arrow down')

                                                                </div>
                                                            </a>
                                                            </th>
                                                            <th scope="col">Top Artists<span data-toggle="tooltip" data-placement="right" title="Click on the artist's name and get more results">
                                                                    <i class="far fa-question-circle"></i>
                                                                </span></th>
                                                            <th scope="col">Top Genres</th>
                                                            <th scope="col">Contact Details</th>
                                                            </tr>

                                                            @endif
                                                            </thead>
                                                            <tbody>
                                                                @foreach($playlists as $playlist)
                                                                @php
                                                                $shouldBlur = user()->subscription()->plan->isFree() && $loop->iteration > 3 && !$playlist->isUnlocked();
                                                                @endphp
                                                                <tr class="{{ $shouldBlur ? 'premium-content' : '' }}">
                                                                    <td class="w-25">{{ $playlist->name }}</td>

                                                                    <td class="followers">{{ $playlist->formatted_followers }}</td>
                                                                    <td class="w-25">
                                                            <x-friendly-date :date="$playlist->last_updated_on"/>
                                                            </td>

                                                            <td class="followers">{{ $playlist->number_of_tracks }}</td>
                                                            <td>
                                                                @foreach(array_slice($playlist->artists, 0, 5) as $artist)
                                                                <a class="hover-text-decoration-none"
                                                                   href="{{ route('frontend.search', ['q' => $artist]) }}">
                                                                    <span
                                                                        class="badge badge-soft-info cursor-pointer artist {{Helpers::stringsMatchWithAccents($artist, request()->query('q'))}}">{{ $artist }}</span>
                                                                </a>
                                                                @endforeach
                                                            <x-modals.show-more :playlist="$playlist" col="artists"
                                                                                :tags="$playlist->artists"/>
                                                            </td>
                                                            <td>
                                                                @foreach(array_slice($playlist->genres, 0, 5) as $genre)
                                                                <a class="hover-text-decoration-none"
                                                                   href="{{ route('frontend.search', ['q' => $genre]) }}">
                                                                    <span
                                                                        class="badge badge-soft-info cursor-pointer genre {{Helpers::stringsMatchWithAccents($genre, request()->query('q'))}}">{{ $genre }}</span>
                                                                </a>
                                                                @endforeach
                                                            <x-modals.show-more :playlist="$playlist" col="genres"
                                                                                :tags="$playlist->genres"/>
                                                            </td>
                                                            <td class="">
                                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                                    @php
                                                                    if ($playlist->isUnlocked()){
                                                                    $modal = "pld_{$playlist->id}_modal";
                                                                    $unlock_text = 'Details';
                                                                    $unlock_class = '';
                                                                    $btn_class = 'btn-success';
                                                                    } else {
                                                                    $modal = $playlist->shouldUnlock() ? 'unlock_playlist_modal' : 'upgrade_to_unlock_modal';
                                                                    $unlock_text = 'Unlock';
                                                                    $unlock_class = $playlist->shouldUnlock() ? 'unlockPlaylistBtn' : '';
                                                                    $btn_class = 'btn-primary';
                                                                    }
                                                                    @endphp

                                                                    <button class="btn btn-sm {{ $btn_class }} {{$unlock_class}}" type="button" data-toggle="modal"
                                                                            data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}" style="display: inherit;">
                                                                        {{ $unlock_text }}</button>
                                                                </div>
                                                            </td>
                                                            @if($playlist->isUnlocked())
                                                            @include('frontend.includes.modals.playlist_details')
                                                            @endif
                                                            </tr>
                                                            @endforeach
                                                            </tbody>
                                                            </table>

                                                            @if(method_exists($playlists, 'links'))
                                                            <div style="line-height: 1;">
                                                                {{ $playlists->appends(request()->query())->links() }}
                                                            </div>
                                                            @endif
                                                            </div>
                                                            @else
                                                            <div class="py-4 ">
                                                                <h4 class="text-center text-muted">{{ $no_result_text }}</h4>
                                                            </div>
                                                            @endif
                                                            </div>
                                                            </div>
                                                            @endif

                                                            @include('frontend.includes.modals.confirm_unlock')
                                                            @include('frontend.includes.modals.upgrade_to_unlock')
                                                            @if($search_limit_exceeded)
                                                            @include('frontend.includes.modals.search_limit_exceeded')
                                                            @endif
                                                            @endsection


                                                            @section('scripts')

                                                            <?php /*
                                                              <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
                                                              <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
                                                             */ ?>


                                                            <script>
                                                                $(function () {
                                                                    $('#search_limit_exceeded_modal').modal('show');

                                                                    $('.unlockPlaylistBtn').click(function () {
                                                                        let playlistId = $(this).data('playlist-id');
                                                                        $('#playlist_id').val(playlistId);
                                                                        $('#unlock_playlist_modal').modal('show');
                                                                    })

                                                                    $(".confirmUnlock").click(function (e) {
                                                                        e.preventDefault();
                                                                        $('#unlock_playlist_modal').modal('toggle');
                                                                        $('#top').addClass('d-none');
                                                                        $('#loader').addClass('d-flex');
                                                                        let $form = $(this).closest('form');

                                                                        setTimeout(
                                                                                function () {
                                                                                    $form.submit();
                                                                                }, 1000
                                                                                );
                                                                    });
                                                                });

                                                            </script>

                                                            @if(session()->has('unlockedPlaylistId'))
                                                            <script>
                                                                $(function () {
                                                                    let modal_id = '#pld_{{session()->get('unlockedPlaylistId')}}_modal';
                                                                    $(modal_id).modal('show');
                                                                });
                                                            </script>
                                                            @endif
                                                            @endsection


                                                            <style>
                                                                body{background: white !important;}
                                                                .navbar-glass {
                                                                    background-color: white !important;
                                                                }
                                                                .card.mb-3 {
                                                                    margin-top: 7%;
                                                                }
                                                                td.w-25
                                                                {
                                                                    -webkit-user-select: none;
                                                                    -khtml-user-select: none;
                                                                    -moz-user-select: none;
                                                                    -ms-user-select: none;
                                                                    -o-user-select: none;
                                                                    user-select: none;
                                                                }

                                                                .badge-soft-info {
                                                                    color: #1978a2;
                                                                    background-color: #d4f2ff;
                                                                    margin: 3px;
                                                                }
                                                            </style>