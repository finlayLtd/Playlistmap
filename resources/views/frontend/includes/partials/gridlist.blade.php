@if(count($playlists))
    @foreach($playlists as $key=>$playlist)
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
        <div class="col-lg-2 col-md-4 col-sm-6 pt-5" data-grid-id="{{$playlist->id}}">
            <div class="w-100 header" style="color:#827F7F;">
                <div class="d-inline w-50 float-left">
                    <i class="mx-2 fa fa-users" aria-hidden="true" style="margin-right:0px !important"></i>
                    <span class="followers">{{ $playlist->formatted_followers }}</span>
                </div>
                <div class="d-inline w-50 float-right">
                    <i class="mx-2 fa-solid fa-album-collection" style="margin-right:0px !important"></i>
                    <span class="tracks">{{ $playlist->number_of_tracks }}</span>
                </div>
            </div>
            <div style="position:relative">
                <div class="mt-2" style="border-radius:20px;box-shadow: 0px 15px 0px -10px rgb(255,255,255,0.3)">
                    <div class="position-relative w-100" style="padding-top:100% !important; box-shadow: 0px 30px 0px -20px rgb(255,255,255,0.3);border-radius: 30px;">
                        <img src="{{ $playlist->image }}" class="w-100 position-absolute @if(!$playlist->isUnlocked()) open-modal-grid @endif" style="top:0px; height:100%;object-fit:cover; border-radius:10px; cursor:pointer"
                            @if($playlist->isUnlocked()) 
                                onclick="window.location.href=`{{route('frontend.playlist_detail', ['playlist_id'=>$playlist->id])}}`"
                            @else 
                                data-toggle="modal" data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}" 
                            @endif
                        >
                    </div>
                    <span class="d-none img-src">{{$playlist->image}}</span>
                </div>
                @if($unlock_text == 'Unlock')
                    <div class="position-absolute w-100 d-flex justify-content-center" style="height:38px; top:calc(50% - 19px)">
                        <button class="btn btn-danger rounded-pill unlock-button @if(!$playlist->isUnlocked()) open-modal-grid @endif"
                            data-toggle="modal" data-target="#unlock_playlist_modal" data-playlist-id="{{ $playlist->id }}" 
                        >
                            <i class="fa-light fa-unlock-keyhole"></i>Unlock
                        </button>
                    </div>
                @endif
                <!-- <div class="position-btn mobile-d-none" style="top:8px; left:8px"><i class="fa-regular fa-heart"></i></div>
                <div class="dropdown dropdown-user-wrapper position-absolute" style="top:8px; right:8px">
                    <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="position-btn ellipsis-button" style="position:relative"><i class="fa-solid fa-ellipsis"></i></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right py-0 bg-transparent">
                        <div class="rounded-lg py-2 links-wrapper">
                            <a class="dropdown-item align-items-center text-white">
                                <i class="me-3 fa-light fa-compact-disc"></i>Top Genres
                            </a>
                            <a onclick="ym(73260880, 'reachGoal', 'profileinusermenu'); return true;" class="dropdown-item align-items-center text-white" >
                                <i class="me-3 fa-solid fa-microphone"></i>Top Artists
                            </a>
                            @if(!$playlist->isUnlocked()) 
                                <a onclick="ym(73260880, 'reachGoal', 'profileinusermenu'); return true;" class="dropdown-item align-items-center text-white @if(!$playlist->isUnlocked()) open-modal-grid @endif"
                                    data-toggle="modal" data-target="#unlock_playlist_modal" data-playlist-id="{{ $playlist->id }}">
                                    <i class="me-3 fa-light fa-unlock-keyhole"></i>Unlock
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="position-btn" style="bottom:8px; left:8px"><i class="fa-solid fa-chart-pie"></i></div> -->
            </div>

            <div class="text-truncate pt-4"><span class="name">{{ $playlist->name }}</span></div>
        <div>
            <span style="color:#827F7F">updated:</span>
            <span class="updated"><x-friendly-date :date="$playlist->last_updated_on"/></span>
        </div>
        </div>
    @endforeach
    @if($playlist->isUnlocked())
        @include('frontend.includes.modals.playlist_details')
    @endif
@else
    <div class="m-auto p-5 h3 text-center" style="color: #837f70">There is no Unlocked playlist</div>
@endif

<style>
    .unlock-button{
        font-size:14px; 
        padding:9px 24px;
    }

    .unlock-button i{
        font-size: 15px;
    }

    .position-absolute .links-wrapper{       
        background: #181818;
        border-radius: 10px;
        border: 1px solid #C0C0C0;
    }

    .links-wrapper a:hover{
        background: #121212;
        cursor: pointer;
    }
    
    @media screen and (max-width:767px) {

        .unlock-button{
            font-size:14px; 
            padding:9px 24px;
        }

        .dropdown:has(.ellipsis-button){
            top:-2px !important;
            right:-2px !important;
        }
    
        .unlock-button i{
            font-size: 15px;
        }

    }
</style>