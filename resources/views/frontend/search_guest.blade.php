@extends('layouts.frontend-main')

@section('content')
    @if(request()->query('q'))

<div class="card" style="background:transparent">
            <div class="card-header bg-100">
               <b style="    font-size: 24px;"> {{ $results_count }} </b>results found for "<b>{{request()->query('q')}}</b>"
            </div>
            <div class="card-body ">
                @if($playlists->count())
                    <div class="alert alert-info text-center container p-md-5 m-md-5" style="background: linear-gradient(95.34deg, #BE281D 1.31%, #2062EF 100.03%); border:none; border-radius:10px; ">
                        <h3  class="text-center text-white" style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 58px;">Create Account</h3>
                        <p class="text-white" style="font-size: 18px">
                           Create a free account to view the search results. You're one click away from reaching your future fans!
                        </p>
                        <a id="btnguestsearch" data-toggle="modal" data-target="#register_modal" style="font-size: 20px" class="btn btn-sm btn-danger rounded-pill">Start for free</a>
                    </div>
                    <div class="table-responsive">
                        <table id="main-search-table" data-pagination="true" data-show-pagination-switch="true" class="container table text-white">
                            <thead class="mobile-d-none">
                                <tr class="">
                                    <th scope="col">Playlist</th>
                                    <th scope="col" colspan="2" class="row" style="padding:10px">
                                        <div class="col-md-6 col-sm-12"></div>
                                        <div class="col-md-6 col-sm-12 row">
                                            <div class="col-4">
                                                @if(request()->input('sortBy') && request()->input('sortBy') === 'followers')
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'followers'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'followers')
                                                    <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'followers'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @else
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => 'followers', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @endif
                                                    <i class="mx-2 fa fa-users" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                            <div class="col-4">
                                                @if(request()->input('sortBy') && request()->input('sortBy') === 'lastUpdated')
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'lastUpdated'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'lastUpdated')
                                                    <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'lastUpdated'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @else
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => 'lastUpdated', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @endif
                                                    <i class="mx-2 fa-sharp fa-solid fa-calendar-week"></i>
                                                </a>
                                            </div>
                                            <div class="col-4">
                                                @if(request()->input('sortBy') && request()->input('sortBy') === 'tracks')
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => null, 'sortByAsc' => 'tracks'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @elseif(request()->input('sortByAsc') && request()->input('sortByAsc') === 'tracks')
                                                    <a href="{{request()->fullUrlWithQuery(['sortByAsc' => null, 'sortBy' => 'tracks'])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @else
                                                    <a href="{{request()->fullUrlWithQuery(['sortBy' => 'tracks', 'sortByAsc' => null])}}" onclick="ym(73260880, 'reachGoal', 'sorting'); return true;">
                                                @endif
                                                    <i class="mx-2 fa-solid fa-clock"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </th>
                                    <th style="width:0;"></th>
                                    <th style="width:0;display:none;"></th>
                                    <th scope="col">Top Artists</th>
                                    <th scope="col">Top Genres</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($playlists as $key=>$playlist)

                                    <tr class="premium-content"style="height:125px" >
                                        <td>
                                            <div class="position-relative d-flex justify-content-center align-items-center">
                                                <div class="position-absolute btn-group mobile-d-none" role="group" aria-label="Basic example">
                                                    <button class="open-modal btn bg-danger d-flex justify-content-center btn-sm text-center rounded-circle border-0" type="button" style="display: inherit; width:40px; height:40px">
                                                        <i class="fa-solid m-0 fa-lock-keyhole"></i>
                                                    </button>
                                                </div>
                                                <img class="img-thumbnail" style="width: 78px; height:78px; object-fit:cover" src="{{ $playlist->image }}" />
                                            </div>
                                        </td>
                                        <td colspan="2" style="height:inherit;">
                                            <div class="row summary">
                                            <div class="col-md-6 col-sm-12 text-left d-flex align-items-center text-ellispe"><span id="playlist_name">{{ $playlist->name }}</span></div>
                                            <div class="col-md-6 col-sm-12 row">
                                                <div class="col-4 followers text-left d-flex align-items-center" style="color:#C0C0C0">
                                                    <i width ="14px" height-="14px" class="mr-fix fa fa-users mobile-d" aria-hidden="true" style="font-size:10px"></i>
                                                    <span id="playlist_followers">{{ $playlist->formatted_followers }}</span>
                                                </div>
                                                <div class="col-4 text-left d-flex align-items-center text-truncate" style="color:#C0C0C0">
                                                    <i width ="14px" height-="14px" class="mr-fix mobile-d fa-sharp fa-solid fa-calendar-week" style="font-size:10px"></i>
                                                    <span id="playlist_updated"><x-friendly-date :date="$playlist->last_updated_on"/></span>
                                                </div>
                
                                                <div class="col-4 followers text-left d-flex align-items-center" style="color:#C0C0C0">
                                                    <i width ="14px" height-="14px" class="mr-fix mobile-d fa-solid fa-clock" style="font-size:10px"></i>
                                                    <span id="playlist_tracks">{{ $playlist->number_of_tracks }}</span>                                        </div>
                                            </div>
                                            </div>
                                        </td>
                                        <td class="mobile-d">
                                            <div class="open-modal rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width:40px; height:40px">
                                                <i class="fa-solid fa-unlock-keyhole"></i>
                                            </div>
                                        </td>
                                        <td class="mobile-d ellipse-border">
                                            <div>
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </div>
                                        </td>

                                        <td class="w-20 text-left mobile-d-none">
                                            @foreach(array_slice($playlist->artists, 0, 5) as $artist)
                                                <a class="hover-text-decoration-none"
                                                    href="{{ route('frontend.search', ['q' => $artist]) }}">
                                                    <span class="badge badge-soft-info cursor-pointer artist {{Helpers::stringsMatchWithAccents($artist, request()->query('q'))}}">
                                                        {{ $artist }}
                                                    </span>
                                                </a>
                                            @endforeach
                                            <x-modals.show-more :playlist="$playlist" col="artists" class="d-inherit" :tags="$playlist->artists"/>
                                        </td>
                                        <td class="w-20 text-left mobile-d-none">
                                            @foreach(array_slice($playlist->genres, 0, 5) as $genre)
                                                <a class="hover-text-decoration-none" href="{{ route('frontend.search', ['q' => $genre]) }}">
                                                    <span class="badge badge-soft-info cursor-pointer genre {{Helpers::stringsMatchWithAccents($genre, request()->query('q'))}}">
                                                        {{ $genre }}
                                                    </span>
                                                </a>
                                            @endforeach
                                            <x-modals.show-more :playlist="$playlist" col="genres" :tags="$playlist->genres"/>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-4 ">
                        <h4 class="text-center text-muted">{{ $no_result_text }}</h4>
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection


@section('scripts')
    <script>
    </script>
@endsection
