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
                    <i class="mx-2 fa fa-calendar-minus" style="margin-right:0px !important" aria-hidden="true"></i>
                    <span class="tracks">{{ $playlist->number_of_tracks }}</span>
                </div>
            </div>
            <div style="position:relative" class="grid-img" style="cursor:pointer">
                <div class="mt-2" style="border-radius:20px;box-shadow: 0px 15px 0px -10px rgb(255,255,255,0.3)">
                    <div class="position-relative w-100" style="padding-top:100% !important; box-shadow: 0px 30px 0px -20px rgb(255,255,255,0.3);border-radius: 30px;">
                        <img src="{{ $playlist->image }}" class="w-100 position-absolute @if(!$playlist->isUnlocked()) open-modal-grid @endif" style="top:0px; height:100%;object-fit:cover; border-radius:10px; cursor:pointer">
                        <div class="position-absolute w-100 h-100 cover-style" style="top:0; cursor:pointer"
                            @if($playlist->isUnlocked()) 
                                onclick="window.location.href=`{{route('frontend.playlist_detail', ['playlist_id'=>$playlist->id])}}`"
                            @else 
                                data-toggle="modal" data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}" 
                            @endif
                        ></div>
                    </div>
                    <span class="d-none img-src">{{$playlist->image}}</span>
                </div>
                @if($unlock_text == 'Unlock')
                    <div class="position-absolute w-100 justify-content-center ulock-btn" style="height:38px; top:calc(50% - 19px)">
                        <button class="btn btn-danger rounded-pill unlock-button @if(!$playlist->isUnlocked()) open-modal-grid @endif"
                            data-toggle="modal" data-target="#unlock_playlist_modal" data-playlist-id="{{ $playlist->id }}" 
                        >
                            <i class="fa-solid me-2 fa-unlock-keyhole"></i>Unlock
                        </button>
                    </div>
                @endif
            </div>

            <div class="text-truncate pt-4"><span class="name">{{ $playlist->name }}</span></div>
        <div style="font-size:13px">
            <span style="color:#827F7F">updated:</span>
            <span class="updated" style="color:#827F7F"><x-friendly-date :date="$playlist->last_updated_on"/></span>
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

    .grid-img .ulock-btn{
        display: none !important;
    }

    .grid-img:hover .ulock-btn{
        display: flex !important;
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

    .grid-img:hover .cover-style{
        background: rgb(0,0,0,0.6);
        transition: 0.3s;
    }
    
    @media screen and (max-width:767px) {

        .unlock-button{
            font-size:14px; 
            padding:9px 24px;
        }

        .grid-img .ulock-btn{
            display: flex !important;
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