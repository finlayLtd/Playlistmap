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
if(isMobileDevice()){ 
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
<<<<<<< HEAD
For the best experience, use your computer <i class="fas fa-laptop"></i>
=======
For the best experience, use your computer

<span data-toggle="tooltip" data-placement="right" title="Use your computer to see additional information such as last update, top artists and genres for each playlist">
            <i class="far fa-question-circle"></i>
        </span>
>>>>>>> e19cfd9a41c9e04a31fc956253eb469629b9f194
  <button style="background: none;
    border: none;
    position: absolute;
    right: 2%;
    top: 2%;
    font-size: 24px;" class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="font-weight-light" aria-hidden="true">×</span></button>
</div>'; 
} 
else { 
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
                        <table class="table border tablesorter" id="order_table">
                            <thead>
                            <tr>
                                <th class="tplaylistname">Playlist Name</th>
                                <th class="tfollowers">Followers</th>
                                <th class="tlastupd">Last Updated</th>
                                <th class="ttracks">Tracks</th>
                                <th class="ttopartists">Top Artists<span data-toggle="tooltip" data-placement="right" title="Click on the artist's name and get more results">
            <i class="far fa-question-circle"></i>
        </span></th>
                                <th class="ttopgenras">Top Genres</th>
                                <th class="tcontact">Contact Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($playlists as $playlist)
                                @php
                                $shouldBlur = user()->subscription()->plan->isFree() && $loop->iteration > 3 && !$playlist->isUnlocked();
                                @endphp
                                <tr class="{{ $shouldBlur ? 'premium-content' : '' }}">
                                    <td id="playlistname" >{{ $playlist->name }}</td>
                                    <td class="followers" data-order="{{$playlist->followers}}">{{ $playlist->FormattedFollowers}}</td>
                                    <td class="lastupdatedon" data-order="{{$playlist->last_updated_on->format('Y-m-d')}}">
                                        <x-friendly-date :date="$playlist->last_updated_on"/>
                                    </td>
                                    <td class="tracks">{{ $playlist->number_of_tracks }}</td>
                                    <td class="topartists">
                                        @foreach(array_slice($playlist->artists, 0, 5) as $artist)
                                            <a class="hover-text-decoration-none"
                                               href="{{ route('frontend.search', ['q' => $artist]) }}">
                                                <span
                                                    class="badge badge-soft-info cursor-pointer">{{ $artist }}</span>
                                            </a>
                                        @endforeach
                                        <x-modals.show-more :playlist="$playlist" col="artists"
                                                            :tags="$playlist->artists"/>
                                    </td>
                                    <td class="topgenres">
                                        @foreach(array_slice($playlist->genres, 0, 5) as $genre)
                                            <a class="hover-text-decoration-none"
                                               href="{{ route('frontend.search', ['q' => $genre]) }}">
                                                <span
                                                    class="badge badge-soft-info cursor-pointer">{{ $genre }}</span>
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
    <script>
        $(function (){
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

        $(document).ready( function () {
         var table= $('#order_table').DataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                "ordering": true,
                "columns":[
                   {
                       "sortable": false
                   },
                   {
                       "sortable": true
                   },
                   {
                       "sortable": true,
                   },
                   {
                       "sortable": false
                   },
                   {
                       "sortable": false
                   },
                   {
                       "sortable": false
                   },
                   {
                       "sortable": false
                   }
               ],
            });
        } );
        $('.page-item').on('click',function () {
            table.ajax.reload();
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
    @media (max-width: 767px) {
    th.tlastupd.sorting,
th.ttracks.sorting_disabled,
th.ttopartists.sorting_disabled,
th.ttopgenras.sorting_disabled, 
td.tracks,
td.topartists,
td.topgenres,
        td.lastupdatedon
{
    display: none !important;
}
        
td.followers {
    width: 25px !important;
}



}
    
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
