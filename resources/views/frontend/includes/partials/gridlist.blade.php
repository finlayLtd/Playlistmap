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
    <div class="col-md-2 col-sm-6 pt-5" data-grid-id="{{$playlist->id}}">
        <div class="w-100 header" style="color:#827F7F;">
            <div class="d-inline w-50 float-left">
                <i class="mx-2 fa fa-users" aria-hidden="true" style="margin-right:0px !important"></i>
                <span class="followers">{{ $playlist->formatted_followers }}</span>
            </div>
            <div class="d-inline w-50 float-right">
                <i class="mx-2 fa-sharp fa-solid fa-calendar-week" style="margin-right:0px !important"></i>
                <span class="tracks">{{ $playlist->number_of_tracks }}</span>
            </div>
        </div>
        <div style="position:relative"  class="@if(!$playlist->isUnlocked()) open-modal-grid @endif" 
            @if($playlist->isUnlocked()) 
                onclick="window.location.href=`{{route('frontend.playlist_detail', ['playlist_id'=>$playlist->id])}}`"
            @else 
                data-toggle="modal" data-target="#{{$modal}}" data-playlist-id="{{ $playlist->id }}" 
            @endif
        >
            <div class="mt-2" style="padding:3px; border-radius:10px; background:white;">
                <div class="img-container" style="postition:relative;background-image:url('{{ $playlist->image }}')">
                </div>
                <span class="d-none img-src">{{$playlist->image}}</span>
            </div>
            <div class="position-absolute w-100 d-flex justify-content-center" style="height:38px; top:calc(50% - 19px)">
                @if($unlock_text == 'Unlock')
                    <button class="btn btn-danger rounded-pill"><i class="fa-light fa-unlock-keyhole"></i>Unlock</button>
                @endif
            </div>
            <div class="position-btn" style="top:8px; left:8px"><i class="fa-regular fa-heart"></i></div>
            <div class="position-btn" style="top:8px; right:8px"><i class="fa-solid fa-ellipsis"></i></div>
            <div class="position-btn" style="bottom:8px; left:8px"><i class="fa-solid fa-chart-pie"></i></div>
        </div>

        <div class="text-truncate pt-4"><span class="name">{{ $playlist->name }}</span></div>
    <div>
        <span style="color:#827F7F">updated:</span>
        <span class="updated"><x-friendly-date :date="$playlist->last_updated_on"/></span>
    </div>
    <!-- <i class="fa-solid fa-unlock-keyhole"></i>
    <i class="fa-solid fa-ellipsis"></i> -->
    </div>
    @if($playlist->isUnlocked())
        @include('frontend.includes.modals.playlist_details')
    @endif
@endforeach
