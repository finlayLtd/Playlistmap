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
                    <span style="font-family: 'Lato';
                            font-style: normal;
                            font-weight: 400;
                            font-size: 14px;
                            line-height: 24px;
                            letter-spacing: -0.0044em;
                            color: #C0C0C0;">
                        {{ $user->subscription()->plan->name }} Plan  
                        <button type="button" disabled class="btn btn-outline-secondary" style="margin-left: 10px; padding: 5px !important; border-radius: 25px !important;">{{ user()->credits }} Credits left</button>
                    </span>
                </div>


            </div>

            <div style="border: 1px solid #121212; margin: 25px 0px; width: 263px; height: 0px;">

            </div>

            <a href="{{route('frontend.profile')}}">
                <div class="cardSelected">
                        <i class="fas fa-user"></i>
                        <span style="margin-left: 8px;">
    
                            Profile
                        </span>
                        <i class="far fa-chevron-right" style="float:right;"></i>
    
                </div>
            </a>
            <a href="{{route('frontend.security')}}">
                <div class="cardRow">
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
        <div style="font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 36px;
            color: #FFFFFF;">
            Profile
        </div>
        <form class="row g-3" action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex align-items-center">
                <div onclick="uploadimage()" class="justify-content-center d-flex align-items-center position-relative rounded-circle" 
                    style="width:85px;height:85px; border:1px solid gray">
                    <i class="no-image fa-solid fa-image"></i>
                    <img class="preview-img object-fit rounded-circle" style="width:85px; height:85px; display:none">
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

        <div style="font-family: 'Lato';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 36px;
            color: #FFFFFF;">
            Personal Details
        </div>
        <div style="font-family: 'Lato';
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: -0.0044em;
            margin-bottom: 16px;
            color: #C0C0C0;">
                General information about your account.
        </div>
        <form class="row g-3" action="{{ route('frontend.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-6">
                <div class="form-outline form-white">
                    <input class="form-control" name="firstName" id="firstName" type="text" value="" >
                    <label class="form-label" for="firstName" style="margin-left: 10px; margin-top: 7px;">
                        First Name
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-outline form-white">
                    <input class="form-control" name="SecondName" id="SecondName" type="text" value="" >
                    <label class="form-label" for="SecondName" style="margin-left: 10px; margin-top: 7px;">
                        Second Name
                    </label>
                </div>
            </div>

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

            



            <!-- <div class="col-12">
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
            </div> -->


            <div class="col-6">
                <div class="form-outline form-white">
                    <input class="form-control" name="birthday"
                            id="birthday" type="text" value="" >
                    <label class="form-label" for="birthday" style="margin-left: 10px; margin-top: 7px;">
                        Date of birth*
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-outline form-white">
                    <input class="form-control" name="location"
                            id="location" type="text" value="" >
                    <label class="form-label" for="location" style="margin-left: 10px; margin-top: 7px;">
                        Location
                    </label>
                </div>
            </div>

           
            
            
           
            <div class="col-12 d-flex" id="save">
                <button onclick="ym(73260880, 'reachGoal', 'profileupdatebtn'); return true;" class="btn btn-primary" type="submit" style="border-radius: 25px; padding: 8px 20px !important;">
                  <i class="far fa-save"></i> Save changes
                </button>
            </div>
        </form>
    </div>
</div>



<style>
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

    ul{
        padding-left: 0px !important;
    }
</style>

@endsection

@section('scripts')
<script>

    function uploadimage(){
        $('.file-upload').trigger('click');
    }

    $(function () {
        $('.reportPlaylistBtn').click(function () {
            let playlistId = $(this).data('playlist-id');
            $('#playlist_id').val(playlistId);
            $('#reportPlaylistModal').modal('show');
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
