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
        <div style="display:inline-block; text-align: left;" class="profileModal">
                
            <div class="row">
                <div class="col-3">
                    @if(user()->avatar_url)
                        <img alt="" class="rounded-circle profile-image ml-4" src="{{ user()->avatar_url }}"  style="width: 60px;"/>
                    @else
                        <!-- <img alt="" class="rounded-circle profile-image ml-4" src="storage/images/users/{{ user()->avatar}}"  style="width: 60px;"/> -->
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

            <a href="{{route('frontend.profile')}}">
                <div class="cardRow">
                        <i class="fas fa-user"></i>
                        <span style="margin-left: 8px;">
    
                            Profile
                        </span>
                        <i class="far fa-chevron-right" style="float:right;"></i>
    
                </div>
            </a>
            <a href="{{route('frontend.security')}}">
                <div class="cardSelected">
                        <i class="fas fa-user-unlock"></i>
                        <span style="margin-left: 8px;">

                            Login & Security
                        </span>
                        <i class="far fa-chevron-right" style="float:right;"></i>

                </div>
            </a>              
            <a href="{{route('frontend.subscription')}}">
                <div class="cardRow">
                        <i class="fas fa-credit-card-blank"></i>
                        <span style="margin-left: 8px;">
                            Subscritption
                        </span>
                        <i class="far fa-chevron-right" style="float:right;"></i>
                </div>
            </a> 
            

            


        </div>

            
        
    </div>
    <div class="col-md-7 newDiv">
        <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;">
            Login & Security
        </div>
     
        <form class="row g-3 updatePassword" action="{{ route('frontend.profile.updatePassword') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="col-12 row" style="margin-top: 24px;">
                <div class="input-group mb-3 gap-2">
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
            
                <div class="col-12 d-flex" id="save">
                    <button class="d-inline-blck btn rounded-pill text-white me-2" style="border:1px gray solid"> Cancel </button>
                    <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary text-truncate submit_button" style="border-radius: 25px; padding: 8px 20px !important;">
                        <i class="far fa-save"></i> Update Password
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>



<style>

    .btn{
        background-color: #1b1b1b;
    }

    .form-outline .form-control.active~.form-label, .form-outline .form-control:focus~.form-label {
        transform: translateY(-1rem) translateY(-0.2rem) scale(.8);
    }

    .profileModal{
        padding: 24px;
        gap: 32px;
        background: #1B1B1B;
        border-radius: 10px;
    }

    .nameClass{
        font-family: 'Lato';
        font-style: normal;
        font-weight: 700;
        font-size: 24px;
        line-height: 36px;
        color: #FFFFFF;
    }

    .cardRow{
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

    .cardSelected{
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


    


    @media screen and (min-width:768px){
        #save{
            justify-content: flex-end!important;
        }
        .newDiv{
            padding: 20px;
        }
    }


    @media screen and (max-width:767px){
        #save{
            justify-content: center !important;
        }
        .newDiv{
            padding: 44px;
        }
    }
</style>

@endsection

@section('scripts')
<script>
    $(function () {
        $('.reportPlaylistBtn').click(function () {
            let playlistId = $(this).data('playlist-id');
            $('#playlist_id').val(playlistId);
            $('#reportPlaylistModal').modal('show');
        });

        $(".submit_button").click(function(){
            if($("#password").val()==$("#confirm_password").val()){
                $(".updatePassword").submit();
            } else {
                $(".comfirm_error").html("<p class='text-danger'>Confirm Password should be the same as password.</p>");
            }
        });
        $('.edit_email').click(function(){
            $(".email_input input").css('background', "#1b1b1b");
            $(".email_input input").trigger('focus');
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
