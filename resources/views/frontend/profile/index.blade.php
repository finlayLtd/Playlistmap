@extends('layouts.frontend')

@section('content')
<div class="row mb-4">
    <div class="col-12 col-md-8 mb-4 mb-md-0">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Update Profile</h5>
            </div>
            <div class="card-body bg-light">
                <form class="row g-3" action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-12">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control @error('name') is-invalid @enderror" name="name"
                               id="name" type="text" value="{{ old('name', $user ? $user->name : '') }}">
                        <x-error field="name"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" name="email"
                               id="email" type="text" value="{{ old('email', $user ? $user->email : '') }}">
                        <x-error field="email"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="password">Change password</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password"
                               id="password" type="text" >
                        <x-error field="password"/>
                    </div>
                    <!--
                    <div class="form-group col-12">
                        <label>Profile Image:</label>
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar">
                        @include('backend.includes.partials.error', ['field' => 'avatar'])

                    </div>
                    
                    -->
                    <div class="col-12 d-flex justify-content-end">
                        <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary" type="submit">
                            {{ isset($submit_text) ? $submit_text : ( $user ? 'Update' : 'Create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Plan</h5>
            </div>
            <div class="card-body bg-light d-flex" style="flex-direction: column;justify-content: center;">
                <div class="mb-4">

                    <h5 class="mb-4 text-bold">{{ old('name', $user ? $user->name : '') }} 👋</h5>
                    @if($user->subscription()->plan->name === "Free")
                    <h6 class="mb-4">{{ $user->subscription()->plan->name }} Plan</h6>
                    
                    @else
                    <h6 class="mb-4">You purchased a {{ $user->subscription()->plan->name }} plan on {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->subscription()->created_at)->format('d/m/Y')}}</h6>
                    
                    @endif
                        
                    <div class="d-flex justify-content-around">
                        <h6 style="    font-size: 11.5px;
                            color: #a9a9a9;">Credits Left:</h6>
                        <div class="rounded p-1">
                            <p class="mb-1" style="    font-size: 13px;
                               color: #262626;
                               font-weight: 500;line-height: 0;">{{ user()->credits }}</p>
                        </div>
                        <h6 style="    font-size: 11.5px;
                            color: #a9a9a9;">Searches Left:</h6>
                        <div class="rounded p-1">
                            <p class="mb-1" style="    font-size: 13px;
                               color: #262626;
                               font-weight: 500;line-height: 0;">{{ user()->search_limit }}</p>
                        </div></div>

                </div>
                <a onclick="ym(73260880, 'reachGoal', 'profilemanageplans'); return true;" href="{{ route('frontend.profile.plans') }}" class="btn btn-primary">UPGRADE</a>
            </div>
        </div>
    </div>
</div>
<div class="row mb-4">
    <div class="col-md-12 col-md-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Update Spotify Artist</h5>
            </div>
            <div class="card-body bg-light">
                <form class="row g-3" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="spotify-artist-id" value="{{ old('spotify-artist-id') }}"/>
                    <input type="hidden" name="spotify-artist-image" value="{{ old('spotify-artist-image') }}"/>

                    <div class="row col-4">
                        <div id="artist-wrapper" class="mb-3 ui artist">
                            <label for="name" class="form-label">{{ __('Your Spotify Artist Name:') }}</label>
                            <input id="artist-id" type="text" class="form-control profile-artist-id" name="artist-id" value="{{ old('name', $user ? $user->name : '') }}" autocomplete="artist-id" disabled="disabled">
                            <x-error field="artist-id"></x-error>
                        </div>
                        <div class="artist-image-wrapper col-md-6">
                            <img id="artist-image" src="https://i.scdn.co/image/ab6761610000e5ebefeb80bd23b299d413c04d8f" />
                        </div>
                    </div>


                    <!--                    <div class="col-4">
                                            <label class="form-label" for="name">Your Spotify Artist Name:</label>
                                            <input class="form-control" id="artist-id" type="text" value="{{ old('name', $user ? $user->name : '') }}"  disabled="disabled" >
                                            <x-error field="name"/>
                                        </div>-->
                    <div class="row">
                        <div class="col-4 d-flex justify-content-start">
                            <button id="change-artist-id" class="btn btn-primary">Change</button>
                            <button id="profile-update-artist-id" class="btn btn-primary d-none" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-soft-secondary">
                <h5 id="myunlocks" class="mb-0">My Unlocks</h5>
            </div>
            <div class="card-body">
                @if($playlists->count())
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="bg-200 text-900">
                            <tr>
                                <th scope="col">Playlist Name</th>
                                <th scope="col">Followers</th>
                                <th scope="col">Unlocked</th>
                                <th scope="col" class="text-right">Contact Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($playlists as $playlist)
                            <tr>
                                <td class="w-25">{{ $playlist->name }}</td>
                                <td>{{ $playlist->formatted_followers }}</td>
                                <td class="w-25">
                        <x-friendly-date :date="$playlist->pivot->created_at"/>
                        </td>
                        <td class="text-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button onclick="ym(73260880, 'reachGoal', 'profileseed'); return true;" class="btn btn-sm btn-primary" type="button" data-toggle="modal"
                                        data-target="#pld_{{ $playlist->id }}_modal">See Details
                                </button>
                                <button onclick="ym(73260880, 'reachGoal', 'profilereportplaylist'); return true;" class="btn btn-sm btn-danger reportPlaylistBtn" type="button"
                                        data-playlist-id="{{ $playlist->id }}">Report
                                </button>
                            </div>
                        </td>
                        @include('frontend.includes.modals.playlist_details')
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div style="line-height: 1;">
                        {{ $playlists->links() }}
                    </div>
                </div>
                @include('frontend.includes.modals.report_playlist')
                @else
                <div class="py-4 ">
                    <h4 class="text-center text-muted">You have not unlocked any playlist yet</h4>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(function () {
        $('.reportPlaylistBtn').click(function () {
            let playlistId = $(this).data('playlist-id');
            $('#playlist_id').val(playlistId);
            $('#reportPlaylistModal').modal('show');
        });
    });


</script>
<script
    src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
