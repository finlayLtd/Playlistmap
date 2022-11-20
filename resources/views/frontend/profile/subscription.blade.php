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
                <div class="cardRow">
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
                <div class="cardSelected">
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

        <div style="font-family: 'Lato';font-style: normal;font-weight: 700;font-size: 24px;line-height: 36px;color: #FFFFFF;margin-top:40px;" class="text-center">
            Payment Methods
            <div style="font-weight: 400;font-size: 16px;line-height: 24px;letter-spacing: -0.0044em;margin-top:16px">
                Securely add or remove payment methods.
                <button type="button" class="manage-plan btn btn-outline-secondary" style="margin-left: 10px; margin-top:16px; padding: 10px !important; border-radius: 25px !important; color: white; float:right;"> Manage Payments</button>
            </div>
        </div>
        
    </div>
</div>



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

    @media screen and (max-width:767px){
        #save{
            justify-content: center !important;
        }
        .newDiv{
            padding: 44px;
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
