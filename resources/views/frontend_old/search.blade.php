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
        <form id="search-view-form" class="" action="{{ route('frontend.search') }}">
            <div class="input-group w-75 mx-auto search-input-wrapper">
                <input id="search-box-input" class="form-control input-search" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                       placeholder="Type Music Genres, Artists Names, Playlist Names"/>
                <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
            </div>
            <div class="search-view-form-message w-75 mx-auto">Search keyword should be longer than 2 characters</div>
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
                                <svg version="1.1" id="Capa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                      c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                      c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                      c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                </g>
                                </g>
                                </svg>
                                <svg version="1.1" id="Capa_1" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                      c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                      l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                      l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                </g>
                                </g>
                                </svg>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="title free tooltip-wrapper">
                                <span class="tooltiptext">Upgrade your plan to sort results</span>
                                Last Updated
                                <svg version="1.1" id="Capa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                      c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                      c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                      c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                </g>
                                </g>
                                </svg>
                                <svg version="1.1" id="Capa_1" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                      c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                      l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                      l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                </g>
                                </g>
                                </svg>
                            </div>
                        </th>
                        <th scope="col">
                            <div class="title free tooltip-wrapper">
                                <span class="tooltiptext">Upgrade your plan to sort results</span>
                                Tracks
                                <svg version="1.1" id="CCCCDDCapa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                      c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                      c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                      c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                </g>
                                </g>
                                </svg>
                                <svg version="1.1" id="DDDCapa_2" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                <g>
                                <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                      c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                      l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                      l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                </g>
                                </g>
                                </svg>
                            </div>
                        </th>
                        <th scope="col">Top Artists</th>
                        <th scope="col">Top Genres</th>
                        <th scope="col">Contact Details</th>

                        @else
                        <th scope="col">Playlist Name</th>
                        <th scope="col">
                            @if(request()->input('sortBy') && request()->input('sortBy') === 'followers')
                            <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'followers'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'followers')
                                <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'followers'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                    @else
                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => 'followers', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                        @endif
                                        <div class="title 
                                             @if(request()->input('sortBy') && request()->input('sortBy') === 'followers')
                                             current-down
                                             @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'followers')
                                             current-up
                                             @endif
                                             ">
                                            Followers
                                            <svg version="1.1" id="Capa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <g>
                                            <g>
                                            <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                                  c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                                  c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                                  c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                            </g>
                                            </g>
                                            </svg>
                                            <svg version="1.1" id="Capa_1" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                            <g>
                                            <g>
                                            <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                                  c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                                  l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                                  l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                            </g>
                                            </g>
                                            </svg>

                                        </div>
                                    </a></th>
                                    <th scope="col">

                                        @if(request()->input('sortBy') && request()->input('sortBy') === 'lastUpdated')
                                        <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'lastUpdated'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                            @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'lastUpdated')
                                            <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'lastUpdated'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @else
                                                <a href="{{request()->fullUrlWithQuery(['sortBy' => 'lastUpdated', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                    @endif

                                                    <div class="title 
                                                         @if(request()->input('sortBy') && request()->input('sortBy') === 'lastUpdated')
                                                         current-down
                                                         @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'lastUpdated')
                                                         current-up
                                                         @endif
                                                         ">
                                                        Last Updated
                                                        <svg version="1.1" id="Capa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                        <g>
                                                        <g>
                                                        <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                                              c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                                              c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                                              c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                                        </g>
                                                        </g>
                                                        </svg>
                                                        <svg version="1.1" id="Capa_1" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                        <g>
                                                        <g>
                                                        <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                                              c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                                              l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                                              l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                                        </g>
                                                        </g>
                                                        </svg>

                                                    </div>
                                                </a>
                                                </th>
                                                <th scope="col">
                                                    @if(request()->input('sortBy') && request()->input('sortBy') === 'tracks')
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'tracks'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                        @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'tracks')
                                                        <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'tracks'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                            @else
                                                            <a href="{{request()->fullUrlWithQuery(['sortBy' => 'tracks', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                                @endif

                                                                <div class="title 
                                                                     @if(request()->input('sortBy') && request()->input('sortBy') === 'tracks')
                                                                     current-down
                                                                     @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'tracks')
                                                                     current-up
                                                                     @endif
                                                                     ">
                                                                    Tracks
                                                                    <svg version="1.1" id="Capa_1" class="sort-arrow up" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                    <g>
                                                                    <g>
                                                                    <path d="M374.176,110.386l-104-104.504c-0.006-0.006-0.013-0.011-0.019-0.018c-7.818-7.832-20.522-7.807-28.314,0.002
                                                                          c-0.006,0.006-0.013,0.011-0.019,0.018l-104,104.504c-7.791,7.829-7.762,20.493,0.068,28.285
                                                                          c7.829,7.792,20.492,7.762,28.284-0.067L236,68.442V492c0,11.046,8.954,20,20,20c11.046,0,20-8.954,20-20V68.442l69.824,70.162
                                                                          c7.792,7.829,20.455,7.859,28.284,0.067C381.939,130.878,381.966,118.214,374.176,110.386z"/>
                                                                    </g>
                                                                    </g>
                                                                    </svg>
                                                                    <svg version="1.1" id="Capa_1" class="sort-arrow down" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                         viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                    <g>
                                                                    <g>
                                                                    <path d="M374.108,373.328c-7.829-7.792-20.492-7.762-28.284,0.067L276,443.557V20c0-11.046-8.954-20-20-20
                                                                          c-11.046,0-20,8.954-20,20v423.558l-69.824-70.164c-7.792-7.829-20.455-7.859-28.284-0.067c-7.83,7.793-7.859,20.456-0.068,28.285
                                                                          l104,104.504c0.006,0.007,0.013,0.012,0.019,0.018c7.792,7.809,20.496,7.834,28.314,0.001c0.006-0.007,0.013-0.012,0.019-0.018
                                                                          l104-104.504C381.966,393.785,381.939,381.121,374.108,373.328z"/>
                                                                    </g>
                                                                    </g>
                                                                    </svg>

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
                                                                $shouldBlur = user()->subscription()->plan->isFree() && $loop->iteration > 3;
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

                                                            @if($currentUnlockedPlaylist !== false)
                                                                @php
                                                                $playlist = $currentUnlockedPlaylist;
                                                                @endphp
                                                                @include('frontend.includes.modals.playlist_details')
                                                                @endif
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