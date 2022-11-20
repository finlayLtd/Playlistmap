<div class="self-modal modal fade" id="profile_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:100000;">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content login-modal position-relative" style="height:100vh">
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-auto container row">
                    <div class="d-flex align-items-center p-0 mt-2" style="color:#C0C0C0">
                        <span style="cursor:pointer" data-dismiss="modal" aria-label="Close"><i class="me-2 text-white mobile-d fa-regular fa-chevron-left" width="20px" height="20px"></i></span> Profile
                    </div>
                    <div class="text-left mt-5" style="font-family: 'Lato'; font-style: normal; font-weight: 700; font-size: 24px; line-height: 36px; color: #FFFFFF;">
                        Profile
                    </div>
                    <form class="row g-3" action="{{ route('frontend.profile.updateAvatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-center">
                            <div onclick="uploadimage()" class="justify-content-center d-flex align-items-center position-relative rounded-circle" 
                                style="width:85px;height:85px; border:1px solid gray">
                                @if(user()->avatar_url)
                                    <img class="preview-img object-fit rounded-circle" id="origin-img" style="width:85px; height:85px;"/>
                                @else
                                    <i class="no-image fa-solid fa-image"></i>
                                    <img class="preview-img object-fit rounded-circle" style="width:85px; height:85px; display:none"/>
                                @endif
                                <div class="position-absolute rounded-circle d-flex justify-content-center align-items-center" 
                                    style="width:25px;height:25px; background-color:gray; bottom:0px;right:0px">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                            <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary disabled upload-image" type="submit" style="border-radius: 25px; padding: 8px 20px !important; margin-bottom: 20px;">
                                Upload Image
                            </button>
                        </div>
                        <div class="form-group col-12 d-none">
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror file-upload" name="avatar">
                            @include('backend.includes.partials.error', ['field' => 'avatar'])
                        </div>
                    </form>
                    <div class="text-left mt-5" style="font-family: 'Lato'; font-style: normal; font-weight: 700; font-size: 24px; line-height: 36px; color: #FFFFFF;">
                        Personal Details
                    </div>
                    <div class="text-left" style="font-family: 'Lato';font-style: normal;font-weight: 400;font-size: 16px;line-height: 24px;letter-spacing: -0.0044em;margin-bottom: 16px;color: #C0C0C0;">
                            General information about your account.
                    </div>
                    <form class="row g-3" action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <div class="form-outline form-white">
                                <input class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full Name"
                                        id="name" type="text" value="{{ old('name', $user ? $user->name : '') }}">
                                <x-error field="name"/>
                                <label class="form-label" for="name" style="margin-left: 10px; margin-top: 7px;">
                                    Full Name
                                </label>
                            </div>
                        </div>
                    
                        <div class="col-12 d-flex justify-content-end" id="save">
                            <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary" type="submit" style="border-radius: 25px; padding: 8px 20px !important;">
                            <i class="far fa-save"></i> Save changes
                            </button>
                        </div>
                    </form>
                    <form method="POST" action="{{ route('frontend.profile.update-spotify-artist') }}">
                        @csrf
                        <input type="hidden" name="spotify-artist-id" value="{{ old('spotify-artist-id') }}"/>
                        <input type="hidden" name="spotify-artist-image" value="{{ old('spotify-artist-image') }}"/>
                        <div class="row position-relative mt-3">
                            <div class="col-md-6 col-sm-12 row flex-column pe-0">
                                <div id="artist-wrapper" class="form-outline form-white mb-3 ui artist pe-0">
                                    <input id="artist-id" type="text" class="artist-id form-control @error('artist-id') is-invalid @enderror"
                                            name="artist-id" value="{{ old('artist-id') }}" autocomplete="artist-id" autofocus placeholder="Spotify Artist">
                                    <x-error field="artist-id"></x-error>
                                    <label class="form-label" for="name" style="left:26px;margin-left: 10px; margin-top: 7px;">
                                        Spotify Artist
                                    </label>
                                </div>
                                <div class="col-md-6 col-sm-12 d-flex" id="save">
                                    <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="text-truncate btn btn-primary rounded-pill" type="submit" style="padding: 8px 20px !important;">
                                        <i class="far fa-save"></i> Save Artists
                                    </button>
                                </div>
                            </div>
                            <ul class="spotify-list profile-spotify bg-white p-4 position-absolute overflow-scroll"></ul>
                            <div class="col-md-6 col-sm-12 row image-container m-auto">
                                <img width="100%" id="artist-image" class="image-thumbnail" src="{{user()->avatar_url}}" style="display:none;background-size:cover;"/>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>