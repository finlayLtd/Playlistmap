@extends('layouts.frontend-main ')

@section('content')
<?php
    session_start();
?>
<div class="homepage-section m-auto align-items-center text-center d-flex flex-column justify-content-center homepage-section-hero @if(request()->query('q')) d-none @endif" style="height:770px;background:linear-gradient(180deg, rgba(18, 18, 18, 0) -26%, rgba(18, 18, 18, 0.787848) -4.22%, #121212 58%), url(http://localhost:8000/images/bg/hero.jpg)">
    <p class="row col-md-6 col-sm-12 container h1 text-center h-auto">Get on the right playlist & reach your future fans</p>
    <form class="row col-md-8 col-sm-12" action="{{ route('frontend.search') }}">
        <div class="input-group bg-white rounded-pill p-0">
            <input class="form-control search_input rounded-pill border-0 m-2" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                placeholder="Type Music Genres, Artists Names, Playlist Names"/>
            <button type="submit" class="input-group-text float-right m-2 rounded-circle bg-danger border-0 text-light" style="width:50px; height:50px"><i class="fa fa-search"></i></button>
        </div>
    </form>
    <div class="row col-md-6 col-sm-12 mx-auto text-center justify-content-center">

        <ul class="list-inline">
            <li class="search-nav list-inline-item"><div class="dots" style="background-color:#FBDE4B"></div>Genres</li>
            <li class="search-nav list-inline-item"><div class="dots" style="background-color:#2062EF"></div>Artist</li>
            <li class="search-nav list-inline-item"><div class="dots" style="background-color:#BE281D"></div>Playlists</li>
        </ul>
        @if(!request()->query('q') && $playlists->count() < 1)
        @foreach($keywords as $keyword)
        <span class="badge badge-soft-info">
            <a class="hover-text-decoration-none"
            href="{{ route('frontend.search', ['q' => $keyword->name]) }}">{{ $keyword->name }}</a>
        </span>
        @endforeach
        @endif
    </div>
</div>
@if(request()->query('q') &&!$search_limit_exceeded)
    <?php
        function isMobileDevice() {
            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo 
            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
            , $_SERVER["HTTP_USER_AGENT"]);
        }
    ?> 
    <div class="container row m-auto justify-content-center mt-5 pt-5">
        <div class="justify-content-center">
            <form action="{{ route('frontend.search') }}">
                <div class="input-group rounded-pill p-0"  style="background-color:#1b1b1b">
                    <input class="form-control search_input rounded-pill border-0 py-0 bg-transparent text-white" type="text" name="q" value="{{ old('keyword', request()->get('q')) }}"
                        placeholder="Type Music Genres, Artists Names, Playlist Names"
                    />
                    <span class="text-black bg-secondary rounded-circle justify-content-center d-flex align-items-center m-auto" style="width:24px; height:24px">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                    <button type="submit" class="input-group-text float-right rounded-circle bg-transparent border-0 text-light" style="width:50px; height:50px"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>

        <div class="row mt-3 mb-3 d-inline container">
            <div class="col-md-6 col-sm-12 align-items-center text-left d-inline-flex align-items-center">
                Search results for:
                <div class="d-inline-flex badge badge-soft-info" style="background:#1b1b1b!important; margin-left:15px!important">
                    {{request()->get('q')}}
                    <span class="text-black bg-secondary rounded-circle justify-content-center d-flex align-items-center m-auto" style="margin-left:5px !important;width:20px; height:20px">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 d-inline badge badge-soft-info result-found text-right text-white" style="color:blue !important;background:#1b1b1b !important">
                {{ $results_count }}  Results found
            </div>
        </div>

        <div class="px-3 container">
            <div class="d-inline float-left badge badge-soft-info text-white border border-white" style="background:#1b1b1b !important; padding: 8px 24px;">
                <i class="fa-solid fa-bars-filter"></i>
                Filters
            </div>
            <div class="d-inline-flex mb-2" style="float:right;">
                <span onclick="changeLayout(true)" class="text-white justify-content-center d-flex align-items-center m-auto" style="margin-left:5px !important;width:25px; height:25px; background:#1b1b1b">
                    <i class="fa-solid fa-grid-2"></i>
                </span>
                <span onclick="changeLayout(false)" class="text-white justify-content-center d-flex align-items-center m-auto" style="margin-left:5px !important;width:25px; height:25px; background:#1b1b1b">
                    <i class="fa-solid fa-list"></i>
                </span>
            </div>
        </div>

        <div class="container m-3 filters" style="background:#1b1b1b; border-radius:10px">
            <div style="width:20%; color:#C0C0C0;" class="mt-2 mx-2">
                <i class="mx-2 fa fa-users" aria-hidden="true"></i>Followers
                <select class="form-select mt-2 border-0 filter-form form-select-lg b mb-3" style="height: 48px; background-color:#121212" aria-label=".form-select-lg example">
                    <option value="1">10.5k</option>
                    <option value="2">9k</option>
                    <option value="3">5k</option>
                </select>
            </div>
            <div style="width:20%; color:#C0C0C0;" class="mt-2 mx-2">
                <i class="mx-2 fa-sharp fa-solid fa-calendar-week"></i>Tracks
                <select class="form-select mt-2 border-0 filter-form form-select-lg b mb-3" style="height: 48px; background-color:#121212" aria-label=".form-select-lg example">
                    <option value="1">10.5k</option>
                    <option value="2">9k</option>
                    <option value="3">5k</option>
                </select>
            </div>
            <div style="width:20%; color:#C0C0C0;" class="mt-2 mx-2">
                <i class="mx-2 fa-solid fa-clock"></i>Time Updated
                <select class="form-select border-0 mt-2 filter-form form-select-lg b mb-3" style="height: 48px; background-color:#121212" aria-label=".form-select-lg example">
                    <option value="1">10.5k</option>
                    <option value="2">9k</option>
                    <option value="3">5k</option>
                </select>
            </div>
            <div style="width:20%; color:#C0C0C0;" class="mt-2 mx-2">
                <i class="mx-2 fa-solid fa-microphone"></i>Artists
                <select class="form-select border-0 mt-2 filter-form form-select-lg b mb-3" style="height: 48px; background-color:#121212" aria-label=".form-select-lg example">
                    <option value="1">10.5k</option>
                    <option value="2">9k</option>
                    <option value="3">5k</option>
                </select>
            </div>
            <div style="width:20%; color:#C0C0C0;" class="mt-2 mx-2">
                <i class="mx-2 fa-light fa-compact-disc"></i>Genres
                <select class="form-select border-0 mt-2 filter-form form-select-lg b mb-3" style="height: 48px; background-color:#121212" aria-label=".form-select-lg example">
                    <option value="1">10.5k</option>
                    <option value="2">9k</option>
                    <option value="3">5k</option>
                </select>
            </div>
        </div>
    </div>
    <div>
        @if($playlists->count())
            @if(user()->subscription()->plan->isFree())
                <div class="alert alert-info text-center">
                    <h3 class="text-center text-uppercase">Upgrade</h3>
                    <p>
                        Want to see more playlists? Upgrade your plan to unlock up to 100 playlists per month!
                    </p>
                    <a id="btnguestsearch" href="{{ route('frontend.profile.plans') }}" class="btn btn-sm btn-success">Upgrade Now</a>
                </div>
            @endif

            <div class="table-responsive container" style="display:@php if( !isset($_SESSION['grid']) || !$_SESSION['grid'] ) echo('block'); else echo('none'); @endphp;">
                <table id="main-search-table" data-pagination="true" data-show-pagination-switch="true" class="container table text-white">
                    <thead class="mobile-d-none">
                        <tr class="">
                            @if(user()->subscription()->plan->isFree())
                                <th scope="col">Playlist</th>
                                <th scope="col"></th>
                                <th scope="col">
                                    <i class="mx-2 fa fa-users" aria-hidden="true"></i>
                                </th>
                                <th scope="col">
                                    <i class="mx-2 fa-sharp fa-solid fa-calendar-week"></i>
                                </th>
                                <th scope="col">
                                    <i class="mx-2 fa-solid fa-clock"></i>
                                </th>
                                <th style="width:0;"></th>
                                <th style="width:0;display:none;"></th>
                                <th scope="col">Top Artists</th>
                                <th scope="col">Top Genres</th>

                            @else
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
                                <!-- <th scope="col">Contact Details</th> -->
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($playlists as $key=>$playlist)
                            @php $shouldBlur = user()->subscription()->plan->isFree() && $loop->iteration > 3;
                            @endphp
                            <tr class="{{ $shouldBlur ? 'premium-content' : '' }}" data-id="{{ $playlist->id }}" style="height:125px">
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
                                <td>
                                    <div class="position-relative d-flex justify-content-center align-items-center">
                                        <div class="position-absolute btn-group mobile-d-none" role="group" aria-label="Basic example">
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
                                            
                                            @if($unlock_text == 'Unlock')
                                                <button class="open-modal btn bg-danger d-flex justify-content-center btn-sm {{ $btn_class }} text-center rounded-circle border-0" type="button" data-toggle="modal"
                                                    data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}" style="display: inherit; width:40px; height:40px">
                                                    <i class="fa-solid m-0 fa-lock-keyhole"></i>
                                                </button>
                                            @else
                                            @endif
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
                                    <div class="open-modal rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width:40px; height:40px" 
                                        data-toggle="modal" data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}">
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
                            @if($playlist->isUnlocked())
                                @include('frontend.includes.modals.playlist_details')
                            @endif
                        @endforeach

                        @if($currentUnlockedPlaylist !== false)
                            @php $playlist = $currentUnlockedPlaylist;
                            @endphp
                            @include('frontend.includes.modals.playlist_details')
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="list-responsive container row m-auto" style="display:@php if( isset($_SESSION['grid']) && $_SESSION['grid'] ) echo('flex'); else echo('none'); @endphp;">
                @foreach($playlists as $playlist)
                    @php $shouldBlur = user()->subscription()->plan->isFree() && $loop->iteration > 3;
                    @endphp
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
                    <div class="col-md-2 col-sm-6 pt-5">
                        <div class="w-100 header" style="color:#827F7F;">
                            <div class="d-inline w-50 float-left">
                                <i class="mx-2 fa fa-users" aria-hidden="true" style="margin-right:0px !important"></i>
                                {{ $playlist->formatted_followers }}
                            </div>
                            <div class="d-inline w-50 float-right">
                                <i class="mx-2 fa-sharp fa-solid fa-calendar-week" style="margin-right:0px !important"></i>
                                {{ $playlist->number_of_tracks }}
                            </div>
                        </div>
                        <div style="position:relative">
                            <div class="mt-2" style="padding:3px; border-radius:10px; background:white;">
                                <div class="img-container" style="postition:relative;background-image:url('{{ $playlist->image }}')">
                                </div>
                            </div>
                            <div class="position-btn" style="top:8px; left:8px"><i class="fa-regular fa-heart"></i></div>
                            <div class="position-btn" style="top:8px; right:8px"><i class="fa-solid fa-ellipsis"></i></div>
                            <div class="position-btn" style="bottom:8px; left:8px"><i class="fa-solid fa-chart-pie"></i></div>
                        </div>
                
                        <div class="text-truncate pt-4">{{ $playlist->name }}</div>
                    <div>
                        <span style="color:#827F7F">updated:</span>
                        <x-friendly-date :date="$playlist->last_updated_on"/>
                    </div>
                    <!-- <i class="fa-solid fa-unlock-keyhole"></i>
                    <i class="fa-solid fa-ellipsis"></i> -->
                    </div>
                    @if($playlist->isUnlocked())
                        @include('frontend.includes.modals.playlist_details')
                    @endif
                @endforeach
            </div>

            @if(method_exists($playlists, 'links'))
                <div style="line-height: 1;display:flex;" class="justify-content-center mt-5 pt-5">
                    {{ $playlists->appends(request()->query())->onEachSide(0)->links() }}
                </div>
            @endif
        @else
            <div class="py-4 ">
                <h4 class="text-center text-muted">{{ $no_result_text }}</h4>
            </div>
        @endif
    </div>
@endif

@include('frontend.includes.modals.confirm_unlock')
@include('frontend.includes.modals.upgrade_to_unlock')
@if($search_limit_exceeded)
    @include('frontend.includes.modals.search_limit_exceeded')
@endif

@endsection


@section('scripts')

                                                           


<script>

    function changeLayout(flag){
        if(!flag){
            @php
                $_SESSION['grid']=1
            @endphp
            $('.table-responsive').css('display','block');
            $('.list-responsive').css('display','none');
        } else{
            @php
                $_SESSION['grid']=0
            @endphp
            $('.table-responsive').css('display','none');
            $('.list-responsive').css('display','flex');
        }
    }

    $(function () {
        $('#search_limit_exceeded_modal').modal('show');

        $('.unlockPlaylistBtn').click(function (e) {
            let playlistId = $(this).data('playlist-id');
            console.log('Playlist ID');
            console.log(playlistId);                                                   
            $('#playlist_id').val(playlistId);
            $('#unlock_playlist_modal').modal('show');
        });

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

        $(".open-modal").click(function (e) {
            var playlist_id = $(this).attr('data-playlist-id');
            $(".playlist_unlock_detail img").attr('src', $("tr[data-id='"+playlist_id+"'] img").attr('src'));
            $(".playlist_unlock_detail #playlist_name").text($("tr[data-id='"+playlist_id+"'] span#playlist_name").text());
            $(".playlist_unlock_detail #playlist_followers").text($("tr[data-id='"+playlist_id+"'] span#playlist_followers").text());
            $(".playlist_unlock_detail #playlist_tracks").text($("tr[data-id='"+playlist_id+"'] span#playlist_tracks").text());
            $(".playlist_unlock_detail #playlist_updated").text($("tr[data-id='"+playlist_id+"'] span#playlist_updated").text());

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
    .badge a{
        color:white !important;
    }

    .img-thumbnail{
        max-width:fit-content !important;
    }

    .filter-form:hover,:focus{
        box-shadow:none!important;
    }

    table{
        border-collapse:separate !important;
        border-spacing:0px 8px;
        border:none;
    }

    td span.d-block{
        color:white !important;
        background: #121212 !important;
    }

    td span.badge{
        display: inline-block !important;
        padding: 2px 5px;
        line-height: 26px !important;
        font-size: 12px !important;
        letter-spacing: 0px;
    }


    td, th{
        background: #1b1b1b !important;
        vertical-align:middle !important;
        text-align:center;
    }

    .w-20{
        width:20%;
    }
    
    .text-left{
        text-align:left;
    }

    tbody, td, tfoot, th, thead, tr{
        border-style:hidden !important;
    }

    table thead th .col-4{
        padding-left:20px;
    }

    table tr td:first-child, tr th:first-child{
        border-radius: 10px 0px 0px 10px;
    }

    table tr td:last-child, tr th:last-child, .ellipse-border{
        border-radius: 0px 10px 10px 0px;
    }

    .filter-form{
        height: 40px !important;
        background-color: #121212 !important;
        justify-content: center !important;
        padding: 6px !important;
        border-radius: 10px !important;
    }

    .main{
        padding-bottom:0px !important;
    }

    .result-found{
        float:right;
    }

    .filters{
        display:inline-flex;
    }

    .mobile-d{
        display:none;
    }

    .modal{
        background: rgba(29,29,29,0.6)
    }

    .modal-content{
        background-color: #121212 !important;
    }

    .position-btn{
        width:36px;
        height:36px;
        border-radius:10px;
        background-color: #121212;
        position:absolute;
        color:#827F7F;
        justify-content: center;
        display: flex;
        align-items: center;
    }

    li.page-item {
        margin-right: 20px;
    }

    li.page-item>*{
        width:25px;
        height:25px;
        color:white;
        border-radius:50% !important;
        background:none;
        border:none;
    }

    .page-item.disabled .page-link{
        background: #1b1b1b !important;
    }

    .page-item.disabled:not(:first-child):not(:last-child) .page-link{
        background-color:transparent !important;
        font-size: 25px;
        top: -10px;
    }

    .page-item:first-child a,
    .page-item:first-child span,
    .page-item:last-child a,
    .page-item:last-child span{
        background:#1B1B1B;
        font-size: 26px;
        align-items: center;
        border-radius:50%;
    }

    .page-link{
        text-align: center;
        justify-content: center;
        display: flex !important;
    }

    .img-container{
        width: 100%;
        padding-top: 100% !important;
        background-size: cover;
        border-radius:10px;
    }

    .header{
        font-size:20px;
    }

    table tbody tr:hover td{
        background:#121212 !important;
    }

    table tbody tr:hover{
        outline:1px gray solid;
    }

    @media screen and (max-width:767px) {
        .homepage-section.homepage-section-hero{
            background:none !important;
            height:600px !important;
        }

        .text-ellispe{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        li.page-item {
            margin-right: 10px;
        }

        .header{
            font-size:14px;
        }

        .table.container, .table-responsive.container{
            padding:0 !important;
        }

        table td.mobile-d:last-child{
            border-radius:0px 10px 10px 0px;
        }

        table td[colspan="3"]{
            padding-right:40px;
        }

        .summary{
            font-size:14px!important;
        }

        td img{
            width: 67px !important;
            height:67px !important;
        }

        tr{
            height:100px !important;
        }

        table{
            table-layout:fixed;
        }

        .filters{
            display: none !important;
        }

        .result-found{
            float:left
        }

        .mobile-d-none{
            display:none !important;
        }

        .mr-fix{
            margin-right: 5px;
        }

        .w-20{
            width:0;
        }

        .col-sm-6{
            width:50% !important;
        }

        .summary .col-md-6.col-sm-12:last-child{
            margin-top:10px;
        }

        .mobile-d{
            display:inline-flex;
            height:inherit;
            align-items:center;
        }
    }

    .badge{
        border-radius: 50em !important;
        width: auto !important;
        font-family: 'Lato';
        background-color: rgb(53,23,21) !important;
        font-style: normal;
        font-weight: 400 !important;
        font-size: 16px !important;
        line-height: 24px !important;
    }

    .search_input:focus{
        box-shadow:none !important;
    }

    .mr-1{
        margin-right:2rem;
    }

    .search-nav:not(:last-child){
        margin-top: 20px; 
        margin-right:1rem !important;
        font-family: 'Lato';
        font-weight: 400;
        font-size:14px;
        line-height: 24px;
    }

    div.dots{
        margin-right: 4px;
        margin-bottom:3px;
        display:inline-block;
        width:5px;
        height:5px;
        border-radius: 50%;
    }

    .navbar-glass {
        background-color: white !important;
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