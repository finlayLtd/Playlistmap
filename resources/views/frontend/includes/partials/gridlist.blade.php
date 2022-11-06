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