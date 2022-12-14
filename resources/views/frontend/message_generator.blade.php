@extends('layouts.frontend-main')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/summernote/summernote.css') }}">
@endsection

@section('content')
<div class="message container row m-auto">
    <span class="head_text"><a href="{{url()->previous()}}"><i class="me-2 mobile-d fa-regular fa-chevron-left" width="20px" height="20px"></i></a> Generate Message</span>
    <div class="col-md-8 col-sm-12 p-4 mt-3 card composer-email container">
        <div class="h4">Email</div>
        <input class="form-control border-0" type="text" placeholder="To" value="{{$playlist->contacts[0]}}">
        <input class="form-control border-0" id="subject" type="text" placeholder="subject">
        <div class="input-group mobile-d-none d-none">
            <div class="input-group-prepend">
            <span class="input-group-text border-0 h-100" id="inputGroupPrepend"><i class="fa-solid fa-list-music"></i></span>
            </div>
            <input type="text" class="form-control border-0" value="{{$playlist->owner}}" id="validationDefaultUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
        </div>
        <textarea  class="w-100 container border-0" id="summernote" rows="15" placeholder="Write a message"></textarea>
        <button class="btn btn-primary col-md-3 col-sm-6 rounded-pill" onClick="MyWindow=window.open('https://mail.google.com/mail/?view=cm&fs=1&to={{ $playlist->contact_email }}&su={{ $template->subject }}&body=Copy%20message%20from%20PlaylistMap','MyWindow','width=600,height=300'); return false;">Copy<i class="fa fa-paper-plane ms-2"></i></button>
        <div class="mobile-d">Copy message template is available only via Desktop</div>
    </div>
    <div class="col-md-4 col-sm-12 mt-3 container email-template overflow scroll">
        <div class="ms-2 card py-lg-4 pb-lg-3 pb-2 h-100">
            <div class="h4 container m-0">Email Templates</div>
            <p class="container m-0">Pick a template to start with</p>
            <div class="container overflow-scroll" style="overflow-x:hidden !important">
                @foreach($templates as $key=>$element)
                    <div class="template-item row container border-radius-lg d-flex align-items-center" data-id="{{$key}}">
                        <div class="col-9 d-flex flex-column overflow-hidden">
                            <div class="text-truncate template-subject">{{$element->subject}}</div>
                            <div class="template-content">
                                @php echo(strip_tags($element->body)); @endphp
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-eye me-2"></i>
                            <i class="select-d-none fa-regular fa-circle"></i>
                            <i class="select-d fa-regular fa-circle-dot"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>

    #gmailbtn{
        padding: inherit;
        background: #f14236;
    }

    #gmailbtn:hover{
        background: #ce3328;
    }

    div.tox.tox-tinymce, div.tox.tox-tinymce *{
        border-width:0px !important;
        color:#827F7F;
        fill:#827F7F;
    }

    .tox .tox-toolbar__primary{
        margin: 8px 10px;
        background-image:none!important;
        background-color:#1b1b1b !important;
    }

    .tox .tox-toolbar__primary *{
        background-color:#1b1b1b !important;
    }

    #tinymce.mce-content-body p{
        color:white;
    }

    #inputGroupPrepend{
        width: 36px;
        border-radius: 10px 0px 0px 10px !important;
    }

    .email-template, .composer-email{
        max-height: 660px;
    }

    .message .form-control, div.tox.tox-tinymce *, 
    .message textarea, #inputGroupPrepend {
        background: #121212;
        color:white;
        border-radius:10px;
    }

    body#tinymce{
        padding:8px;
    }

    .template-content *{
        background-color:#121212 !important;
        color: white !important;
    }

    .template-content{
        line-height: 20px;
        height:40px;
        text-overflow: ellipsis;
        overflow: hidden;
        font-size: 14px;
    }


    .message .form-control:not([placeholder="Username"]):focus,
    .message textarea:focus-visible{
        border-color:#2062EF !important;
        border-width:2px !important;
        border-style: solid !important;
        outline:0px;
    }

    .tox-statusbar{
        display:none !important;
    }

    .composer-email:has(input:not([value])) button{
        color: #fff;
        border-color: #0d6efd;
        pointer-events: none;
        opacity: .65;
    }

    div.input-group:has(.form-control:focus){
        border-radius:10px;
        border-color:#2062EF !important;
        border-width:2px !important;
        border-style: solid !important;
    }

    .container.overflow-scroll{
        margin-bottom: 5px;
        background: #1b1b1b;
    }

    .template-item:hover{
        background: #1b1b1b;
        border: 2px solid gray;
    }

    .template-item .select-d{
        display: none;
    }

    .template-item:hover .select-d{
        display: block;
    }

    .template-item:hover .select-d-none{
        display: none;
    }

    .template-item{
        background: #121212;
        height:80px;
        margin:auto;
        margin-bottom:5px;
        padding:0px;
        border-radius:12px;
    }

    .template-item .col-9{
        font-size: 18px;
    }

    .head_text{
        font-size: 35px;
    }

    @media (max-width: 1693px)
    {
        #texttipbox{
            width: 185px!important;
        }
    }


    @media (max-width: 767px)
    {

        .head_text{
            font-size: 20px;
        }

        #gmailbtn
        {
            display:none;
        }
        
        .flexereamobile
        {
            display: block!important;
        }

        #btnchangetitle
        {
            width: 43%!important;
            font-size: 10px;
        }

        .email-template{
            padding:0px;
        }

        .email-template .card{
            margin-left: 0px !important;
        }

        .email-template .h4{
            margin-top:20px !important;
        }

        .tox-editor-container .tox-editor-header{
            margin:10px;
        }

        #texttipbox
        {
            width: 100%!important;
        }
    }

    #btnchangetitle
    {
        width: 15%;
    }

    .flexereamobile
    {
        display: flex;
    }

    .pt-2 {
        padding-top: .5rem!important;
        width: 300px;
    }
</style>

@endsection

@section('scripts')
<script src = "{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
<script src="{{asset('vendors/tinymce/tinymce.min.js')}}"></script>

<script>
    
    $(function () {
        let $summernote = $('#summernote');
        tinymce.init({
            selector: '#summernote',
            menubar: false,
            content_css:"{{ asset('assets/css/style.css') . '?v=' .  config('constants.assets_version') }}"
        });

        $('.template-item').click(function(){
            var index = $(this).attr('data-id');
            var templateArray = eval(<?php echo($templates)?>);
            tinymce.activeEditor.setContent(templateArray[index]['body']);
            $('#subject').val(templateArray[index]['subject']);
            if(screen.width>767)
                $('#subject').attr('value',templateArray[index]['subject']);
        });

        $('.change-template').click(function () {
            changeTemplate($(this).data('field'));
        });

        $('.copy-template').click(function () {
            let field = $(this).data('field');
            let text = '';
            if (field === 'subject') {
                text = $('#subject').val();
            } else if (field === 'message') {
                if ($summernote.summernote('isEmpty') === false) {
                    text = $summernote.summernote('createRange').ec;
                }
            }

            let $temp = $("<textarea>");
            $("body").append($temp);
            $temp.val(text).select();
            document.execCommand("copy");
            $temp.remove();
            toastr.success('Text Copied!')
        });
        function changeTemplate(field) {
            let $request = $.ajax({
                url: "{{ route('frontend.message_generator.change_template', $playlist) }}",
                type: "post",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'field': field,
                }
            });
            $request.done(function (response, textStatus, jqXHR) {
                if (field === 'message')
                    tinymce.activeEditor.setContent(response.message);
                else if (field === 'subject')
                    $('#subject').val(response.subject);
            });
        }
    });
</script>
@endsection