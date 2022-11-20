<div class="self-modal modal fade" id="security_modal" tabindex="-1" aria-labelledby="unlock_playlist_modal"
     aria-hidden="true" data-backdrop="static" data-keyboard="false" style="z-index:100000;">
    <div class="modal-dialog modal-dialog-centered justify-content-center">      
        <div class="modal-content login-modal position-relative" style="height:100vh">
            <div class="modal-body text-center" style=" padding: 0 !important;margin: 0 !important;">
                <div class="m-auto container row">
                    <div class="d-flex align-items-center p-0 mt-2" style="color:#C0C0C0">
                        <span style="cursor:pointer" data-dismiss="modal" aria-label="Close"><i class="me-2 text-white mobile-d fa-regular fa-chevron-left" width="20px" height="20px"></i></span> Login & Security
                    </div>
                    <div class="text-left mt-5" style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;">
                        Login & Security
                    </div>
                
                    <form class="row g-3 updatePassword mt-2" action="{{ route('frontend.profile.updatePassword') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 row" style="margin-top: 24px;">
                            <div class="input-group mb-3 gap-2 p-0">
                                <div class="form-outline form-white email_input">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"  style="background:#121212 !important"
                                            id="email" type="text" value="{{ old('email', $user ? $user->email : '') }}">
                                            <x-error field="email"/>
                                    <label class="form-label" for="email" style="margin-left: 10px; margin-top: 7px;">
                                        Email
                                    </label>
                                </div>
                                <button class="d-inline-block edit_email btn rounded-pill text-white m-auto" onclick="event.preventDefault();return true;" style="border:1px gray solid;height:40px"> Edit </button>
                            </div>
                        </div>
                        <div style="padding: 16px;gap: 16px;width: 809px;height: 292px;border: 1px solid #827F7F;border-radius: 10px;">
                            <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;margin-bottom: 16px;">
                                Edit Password
                            </div>
                            <div class="row">
                                <div class="col-12" style="margin-bottom: 16px;">
                                    <div class="form-outline form-white">
                                        <input class="form-control @error('password') is-invalid @enderror" name="password"
                                            id="password" type="text" >
                                            <x-error field="password"/>
                                        <label class="form-label" for="password" style="margin-left: 10px; margin-top: 7px;">
                                            New password*
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12" style="margin-bottom: 16px;">
                                    <div class="form-outline form-white">
                                        <input class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                                            id="confirm_password" type="text" >
                                            <x-error field="confirm_password"/>
                                        <label class="form-label" for="confirm_password" style="margin-left: 10px; margin-top: 7px;">
                                            Confirm New password*
                                        </label>
                                        <div></div>
                                    </div>
                                    <div class="confirm_error"></div>
                                </div>

                            </div>

                            Minimum 6 characters
                        
                            <div class="col-12 d-flex justify-content-end" id="save">
                                <button class="d-inline-blck btn rounded-pill text-white me-2" style="border:1px gray solid"> Cancel </button>
                                <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary text-truncate submit_button" style="border-radius: 25px; padding: 8px 20px !important;">
                                    <i class="far fa-save"></i> Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>