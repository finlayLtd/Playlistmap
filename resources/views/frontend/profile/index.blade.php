@extends('layouts.frontend-main')

@section('content')
<link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.css"
    rel="stylesheet"
/>
<script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.0/mdb.min.js"
></script>
<div style="height: 70px;">
</div>
<div class="row mb-4">
    <div class="col-md-4" style=" text-align: center;">
        <div style="display:inline-block; text-align: left;" class="profileModal nav nav-tabs" id="tabs" data-tabs="tabs">
                
            <div class="row">
                <div class="col-3">
                    @if(user()->avatar_url)
                        <img class="rounded-circle profile-image ml-4" src="{{ user()->avatar_url }}" alt="" style="width: 60px;"/>
                    @else
                        <!-- <img class="rounded-circle profile-image ml-4" src="storage/images/users/{{ user()->avatar}}" alt="" style="width: 60px;"/> -->
                        <div class="default-avatar-icon">
                            <i class="fas fa-circle-user default-avatar-icon" style="font-size: 60px;"></i>
                        </div>
                    @endif
                </div>
                <div class="col-9">
                    <span class="nameClass" >
                        {{ old('name', $user ? $user->name : '') }}
                    </span>
                    <br>
                    <span style="font-family: 'Lato';font-style: normal;font-weight: 400;font-size: 14px;line-height: 24px;letter-spacing: -0.0044em;color: #C0C0C0;">
                        {{ $user->subscription()->plan->name }} Plan  
                        <button type="button" disabled class="btn btn-outline-secondary" style="margin-left: 10px; padding: 5px !important; border-radius: 25px !important;">{{ user()->credits }} Credits left</button>
                    </span>
                </div>


            </div>

            <div style="border: 1px solid #121212; margin: 25px 0px; width: 263px; height: 0px;">

            </div>

            <!-- <a href="{{route('frontend.profile')}}"> -->
            <a href="#red" class="mobile-d-none @if(!isset($tabnum)) active @endif" data-toggle="tab">
                <div class="">
                    <i class="fas fa-user"></i>
                    <span style="margin-left: 8px;">

                        Profile
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>
    
                </div>
            </a>
            <a href="#red" class="mobile-d w-100" data-toggle="modal" data-target="#profile_modal">
                <div class="">
                    <i class="fas fa-user"></i>
                    <span style="margin-left: 8px;">

                        Profile
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>
    
                </div>
            </a>
            <!-- <a href="{{route('frontend.security')}}"> -->
            <a href="#orange" class="mobile-d-none @if(isset($tabnum) && $tabnum==2) active @endif" data-toggle="tab">
                <div class="">
                    <i class="fas fa-user-unlock"></i>
                    <span style="margin-left: 8px;">

                        Login & Security
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>

                </div>
            </a>              
            <a href="#orange" class="mobile-d w-100" data-toggle="modal" data-target="#security_modal">
                <div class="">
                    <i class="fas fa-user-unlock"></i>
                    <span style="margin-left: 8px;">

                        Login & Security
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>

                </div>
            </a>              
            <!-- <a href="{{route('frontend.subscription')}}"> -->
            <a href="#yellow" class="mobile-d-none  @if(isset($tabnum) && $tabnum==3) active @endif" data-toggle="tab">
                <div class="">
                    <i class="fas fa-credit-card-blank"></i>
                    <span style="margin-left: 8px;">
                        Subscritption
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>
                </div>
            </a> 
            <a href="#yellow" class="mobile-d w-100" data-toggle="modal" data-target="#subscription_modal">
                <div class="">
                    <i class="fas fa-credit-card-blank"></i>
                    <span style="margin-left: 8px;">
                        Subscritption
                    </span>
                    <i class="far fa-chevron-right" style="float:right;"></i>
                </div>
            </a> 
        </div>
    </div>
    <div class="col-md-7 newDiv mobile-d-none">
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane @if(!isset($tabnum)) active @endif" id="red">
                <div style="font-family: 'Lato'; font-style: normal; font-weight: 700; font-size: 24px; line-height: 36px; color: #FFFFFF;">
                    Profile
                </div>
                <form class="row g-3" action="{{ route('frontend.profile.updateAvatar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-flex align-items-center">
                        <div onclick="uploadimage()" class="justify-content-center d-flex align-items-center position-relative rounded-circle" 
                            style="width:85px;height:85px; border:1px solid gray; cursor:pointer">
                            @if(user()->avatar_url)
                                <img class="preview-img object-fit rounded-circle" src="{{user()->avatar_url}}" style="width:85px; height:85px;">
                            @else
                                <i class="no-image fa-solid fa-image"></i>
                                <img class="preview-img object-fit rounded-circle" style="width:85px; height:85px; display:none">
                            @endif
                            <div class="position-absolute rounded-circle d-flex justify-content-center align-items-center" 
                                style="width:25px;height:25px; background-color:gray; bottom:0px;right:0px">
                                <i class="fa-solid fa-plus"></i>
                            </div>
                        </div>
                        <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary m-5 disabled upload-image" type="submit" style="border-radius: 25px; padding: 8px 20px !important; margin-bottom: 20px;">
                            Upload Image
                        </button>
                    </div>
                    <div class="form-group col-12 d-none">
                        <input type="file" class="form-control @error('avatar') is-invalid @enderror file-upload" name="avatar">
                        @include('backend.includes.partials.error', ['field' => 'avatar'])
                    </div>


                    
                </form>

                <div style="font-family: 'Lato'; font-style: normal; font-weight: 700; font-size: 24px; line-height: 36px; color: #FFFFFF;">
                    Personal Details
                </div>
                <div style="font-family: 'Lato';font-style: normal;font-weight: 400;font-size: 16px;line-height: 24px;letter-spacing: -0.0044em;margin-bottom: 16px;color: #C0C0C0;">
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
            <div class="tab-pane @if(isset($tabnum) && $tabnum==2) active @endif" id="orange">
                <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;">
                    Login & Security
                </div>
                
                <div class="col-12 row" style="margin-top: 24px;">
                    <div class="input-group mb-3 gap-2">
                        <div class="form-outline form-white">
                            <input class="form-control @error('email') is-invalid @enderror" name="email"
                                id="email" type="text" value="{{ old('email', $user ? $user->email : '') }}">
                                <x-error field="email"/>
                            <label class="form-label" for="email" style="margin-left: 10px; margin-top: 7px;">
                                Email
                            </label>
                        </div>
                    </div>
                </div>
                
                <form class="row g-3 updatePassword" action="{{ route('frontend.profile.updatePassword') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="padding: 16px;gap: 16px;width: 809px;border: 1px solid #827F7F;border-radius: 10px;">
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
            <div class="tab-pane @if(isset($tabnum) && $tabnum==3) active @endif" id="yellow">
                <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;">
                    Subscritption
                </div>

                <div style="padding: 16px; background: #181818; border-radius: 10px;margin-top:16px">
                    <div class="profile-plan d-flex align-items-center">
                        <div class="thLetter">
                            <span class="title-plan">{{$user->subscription()->plan->name}}</span> <span class="mobile-d-none">Plan</span>
                        </div>
                        <div class="thLetter">
                            Monthly
                        </div>
                        <div class="thLetter position-relative">
                            <span class="price-plan">${{ $user->subscription()->plan->price}}</span><span class="position-absolute" style="font-size:12px;color: #827F7F">/Month</span>
                        </div>
                        <div class="thLetter">
                            {{ $user->subscription()->plan->getFeatureByName('credits'.($user->subscription()->plan->id==1?'':'-'.($user->subscription()->plan->id-1)))->value}} Credits/Month <i class="fas fa-exclamation-circle" style="color: #C0C0C0;"></i>
                        </div>
                        <div class="thLetter d-flex">
                            <button type="button" class="w-100 btn btn-danger" style="background-color:red;margin-left: 10px; padding: 10px !important; border-radius: 25px !important; color: white; float:right; "> <i class="far fa-chevron-down"></i> Manage Plan</button>
                        </div>
                    </div>

                    <div style="margin-top:24px; color: rgba(192, 192, 192, 1);" class="@if($user->subscription()->plan->name == 'Free') d-none @endif">
                        The next payment is due on <span style="color: rgba(251, 222, 75, 1) !important;">{{date_format($user->subscription()->ends_at, "F d, Y")}}</span> . 
                    </div>
                </div>

                <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;margin-top:40px;" class="desc_manage">
                    Payment Methods
                    <div style="font-weight: 400;font-size: 16px;line-height: 24px;letter-spacing: -0.0044em;margin-top:16px">
                        Securely add or remove payment methods.
                        <button type="button" class="manage-plan btn btn-outline-secondary" style="margin-left: 10px; margin-top:16px; padding: 10px !important; border-radius: 25px !important; color: white; float:right;"> Manage Payments</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include("frontend.includes.modals.profile", ['user'=>$user])
@include("frontend.includes.modals.security")
@include("frontend.includes.modals.subscription", ['user'=>$user])



<style>

    .form-outline .form-control.active~.form-label, .form-outline .form-control:focus~.form-label {
        transform: translateY(-1rem) translateY(-0.2rem) scale(.8);
    }

    .thLetter{
        width:20%;
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: -0.0044em;
        color: #FFFFFF;
    }
    .thLetter.position-relative span.position-absolute{
        top: -6px;
    }

    .profileModal{
        padding: 24px;
        gap: 32px;
        background: #1B1B1B;
        border-radius: 10px;
    }

		.image-container img{
				visibility: visible !important;
		}

    .nameClass{
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        line-height: 36px;
        color: #FFFFFF;
    }

    a[data-toggle="tab"]:not(.active) div,
    a[data-toggle="modal"]:not(.active) div{
        cursor: pointer;
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: -0.0044em;
        padding: 16px;
        color: #C0C0C0;
    }

    a.active[data-toggle="tab"] div,
    a.active[data-toggle="modal"] div{
        cursor: pointer;
        background: #121212;
        border: 1px solid #2B3DD0;
        border-radius: 10px;
        font-family: 'Lato';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: -0.0044em;
        padding: 16px;
        color: #C0C0C0;
    }

    .cardRow:hover{
        background: rgba(190, 40, 29, 0.1);
        border-radius: 10px;
    }

    .form-control{
        padding: 12px 16px !important;
        color: rgba(192, 192, 192, 1) !important;
        background: #1B1B1B !important;
        border-radius: 10px !important;
        border: none;
    }
    
    .btn-primary{
        background: #2062EF !important;
    }

    .desc_manage{
        text-align: left;
    }

    .profile-spotify{
        z-index:1;
        height:300px;
        top:55px;
        display:none;
        color:black;
        margin-left: 20px;
    }

    button.upload-image{
        margin:auto;
        margin-left:20px;
    }

    @media screen and (max-width:767px){
        .newDiv{
            padding: 44px;
        }

        .mobile-d{
            display: block;
        }

        .profile-spotify{
            width: 100%;
            margin: auto;
        }

        .desc_manage{
            text-align: center;
        }

        .thLetter.position-relative span.position-absolute{
            top: -12px;
        }

        .thLetter{
            width: 100%;
            margin-bottom: 16px;
        }

        .manage-plan{
            width: 100%;
        }

        .profile-plan{
            display:block !important;
            text-align:center;
        }

        .price-plan{
            font-size: 34px;
        }

        .title-plan{
            font-size: 24px;
        }
    }

    ul{
        padding-left: 0px !important;
    }
</style>

@endsection

@section('scripts')
<script>
    var index=-1;
    function selectArtist(src, text){
        $("input[name='spotify-artist-id']").val(text);
        $("input[name='spotify-artist-image']").val(src);
        $("[id='artist-id']").val(text);
        $("[id='artist-image']").attr('src', src).css('display', 'inline-block').css("visibility", "inherit");
        $('.spotify-list').css('display', 'none');
    }
    
    function uploadimage(){
        $('.file-upload').trigger('click');
    }

    function toDataURL(url, callback) {
        var xhr = new XMLHttpRequest();
        xhr.onload = function() {
            var reader = new FileReader();
            reader.onloadend = function() {
            callback(reader.result);
            }
            reader.readAsDataURL(xhr.response);
        };
        xhr.open('GET', url);
        xhr.responseType = 'blob';
        xhr.send();
    }

    $(function () {
        $('.reportPlaylistBtn').click(function () {
            let playlistId = $(this).data('playlist-id');
            $('#playlist_id').val(playlistId);
            $('#reportPlaylistModal').modal('show');
        });

        $("a[data-target='#profile_modal']").click(function(){
            if(index){
                var temp = "<?php echo(user()->avatar_url);?>"
                toDataURL(temp, function(data){
                    $("#origin-img").attr("src", data);
                });
                index++;
            }
        });

        $(".submit_button").click(function(){
            if($("#password").val()==$("#confirm_password").val()){
                $(".updatePassword").submit();
            } else {
                $(".comfirm_error").html("<p class='text-danger'>Confirm Password should be the same as password.</p>");
            }
        });
        
        $('.edit_email').click(function(){
            $(".email_input input").trigger('focus');
        });

        $('.file-upload').change(function(){
            var preview = document.querySelector('.preview-img');
            var file    = document.querySelector('input[type=file]').files[0];
            var reader  = new FileReader();

            reader.addEventListener("load", function () {
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
                $('.no-image').css('display', 'none');
                $('.preview-img').css('display', 'block');
                $('.upload-image').removeClass('disabled');
            }
        });
    });

    document.querySelectorAll('.form-outline').forEach((formOutline) => { new mdb.Input(formOutline).init(); });
    $(".form-notch").css("display", "none");

</script>
<script
    src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"
    integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E="
crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
