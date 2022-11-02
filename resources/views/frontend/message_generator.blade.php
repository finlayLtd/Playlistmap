@extends('layouts.frontend')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/summernote/summernote.css') }}">
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">

        <a href="javascript:history.back()"><i class="fas fa-arrow-circle-left"></i> Back to Search Results</a>

    </ol>
</nav>
<div class="flexereamobile">
    <div class="card mb-3">
        <div class="card-header">
            <h5 class="mb-0">Generate Message</h5>
        </div>
        <div class="card-body bg-light">
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label d-flex" for="to">Identified Contacts</label>

                    <?php
                    $contactEmail = $playlist->contact_email;
                    $foundMail = false;
                    $contactsSTR = "";
                    $first = true;
                    foreach ($playlist->contacts as $contact) {
                        if ($first) {
                            if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                                $contactsSTR = $contact;
                                $contactEmail = $contact;
                                $foundMail = true;
                            } else {
//                                $contactsSTR = "https://instagram.com/" . substr($contact, 1) . "/";
                                $link = 'https://www.instagram.com/' . substr($contact, 1) . "/";
                                $contactsSTR .= '<a target="_blank" href="' . $link . '">' . $link . '</a>';
                            }
                            $first = false;
                        } else {
//                            $contactsSTR .= ", ";
                            $contactsSTR .= "<br>";
                            if (filter_var($contact, FILTER_VALIDATE_EMAIL)) {
                                $contactsSTR .= $contact;
                                $contactEmail = $contact;
                            } else {
                                $link = 'https://www.instagram.com/' . substr($contact, 1) . "/";
                                $contactsSTR .= '<a target="_blank" href="' . $link . '">' . $link . '</a>';
                            }
                        }
                    }

                    ?>


                    <span>
                        {!!$contactsSTR!!}
                    </span>
<!--                    <input class="form-control" name="to" id="to" type="text"
                           value="{{ $contactsSTR }}">-->
                    <input class="form-control" name="to" id="to" type="hidden"
                           value="{{ $contactEmail }}">


                </div>
                <div class="col-12 d-flex">
                    <input class="form-control d-inline-block" id="subject" type="text"
                           value="{{ $template->subject }}">
                    @if(user()->has_no_plan)
                    <span data-toggle="tooltip" title="Upgrade to view more title ideas">
                        <button onclick="ym(73260880, 'reachGoal', 'changetitle'); return true;" class="btn btn-sm btn-primary change-template"  style="pointer-events: none;height: 100%;" disabled>Change Title <i class="fas fa-retweet"></i></button>
                    </span><br>  <br> <br>

                    @else
                    <button onclick="ym(73260880, 'reachGoal', 'changetitle'); return true;" id="btnchangetitle" class="btn btn-sm btn-primary change-template" type="button" data-toggle="modal" data-field="subject" > Change Title <i class="fas fa-retweet"></i>
                    </button>
                    @endif

                    <div class="text-right align-self-center" >


                    </div>    
                </div>

                <div>  


                </div>  
                <div class="col-12">
                    <div class="">
                        <div class="">
                            <label class="mr-2">Message</label>
                            {{--<i class="fal fa-copy cursor-pointer copy-template mr-1" data-field="message"></i>--}}




                            @if(user()->has_no_plan)

                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Upgrade to view more messages ideas">
                                    <button onclick="ym(73260880, 'reachGoal', 'changemessage'); return true;" class="btn btn-sm btn-primary" style="pointer-events: none;" type="button" disabled>Change Message <i class="fas fa-retweet"></i></button>
                                </span><br> <br>

                                @else
                                <button onclick="ym(73260880, 'reachGoal', 'changemessage'); return true;" class="btn btn-sm btn-primary change-template" type="button" data-toggle="modal" data-field="message"> Change Message <i class="fas fa-retweet"></i>
                                </button>

                                @endif





                        </div>
                        <textarea class="form-control" id="summernote" rows="20">{{ $template->body }}</textarea>
                    </div>
                </div>
            </div>
            <br>



            @if($foundMail)
            <a onclick="ym(73260880, 'reachGoal', 'composemsg'); return true;" style="padding: inherit;" href="mailto:{{ $playlist->contact_email }}?subject={{ $template->subject }}&body=Copy%20message%20from%20PlaylistMap" class="btn btn-primary" role="button" aria-pressed="true">Compose <i class="far fa-edit"></i></a>

            <a id = "gmailbtn" href = "#" class = "btn btn-primary" role = "button" onClick = "MyWindow=window.open('https://mail.google.com/mail/?view=cm&fs=1&to={{ $playlist->contact_email }}&su={{ $template->subject }}&body=Copy%20message%20from%20PlaylistMap','MyWindow','width=600,height=300'); return false;">Gmail <i class = "fab fa-google"></i></a>
 

            @endif
            </div>

            </div>




            <div class = "card mb-3">
            <div class = "card-header">
            <h5 class = "mb-0">Tips 💡</h5>
            </div>
            <div class = "accordion border-x border-top rounded" id = "accordionExample">
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingOne"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 text-left" type = "button" data-toggle = "collapse" data-target = "#collapseOne" aria-expanded = "true" aria-controls = "collapseOne"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">Take your time</span></button></div>
            <div class = "collapse" id = "collapseOne" aria-labelledby = "headingOne" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox">Take your time and reread your email before you press send. You may be sending a lot of emails, but silly mistakes or carelessness can be a turnoff for curators who are used to receiving lots of pitches.</div>
            </div>
            </div>
            </div>
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingTwo"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle = "collapse" data-target = "#collapseTwo" aria-expanded = "false" aria-controls = "collapseTwo"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">Brief and clear</span></button></div>
            <div class = "collapse" id = "collapseTwo" aria-labelledby = "headingTwo" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox" >Be brief and be clear. Do you like reading through long, rambling emails? No? Neither will these folks. </div>
            </div>
            </div>
            </div>
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingThree"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle = "collapse" data-target = "#collapseThree" aria-expanded = "false" aria-controls = "collapseThree"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">Make it personal</span></button></div>
            <div class = "collapse" id = "collapseThree" aria-labelledby = "headingThree" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox" >Make it personal. Your email will resonate a lot more if it strikes a personal chord.
            </div>
            </div>
            </div>
            </div>
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingFour"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle = "collapse" data-target = "#collapseFour" aria-expanded = "false" aria-controls = "collapseFour"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">Use descriptive language</span></button></div>
            <div class = "collapse" id = "collapseFour" aria-labelledby = "headingFour" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox" >Use descriptive language. Help the curator get an idea of what your music sounds like. Do your homework and actually check out the other artists who are already included on their playlists.
            </div>
            </div>
            </div>
            </div>
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingFive"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle = "collapse" data-target = "#collapseFive" aria-expanded = "false" aria-controls = "collapseFive"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">Make a connection</span></button></div>
            <div class = "collapse" id = "collapseFive" aria-labelledby = "headingFive" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox" >Who curated the playlist? More often, musicians, band members, and others in the industry are building playlists. What specific information can you use to make a connection?
            </div>
            </div>
            </div>
            </div>
            <div class = "card shadow-none border-bottom">
            <div class = "card-header p-0" id = "headingSix"><button class = "btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed text-left" data-toggle = "collapse" data-target = "#collapseSix" aria-expanded = "false" aria-controls = "collapseSix"><span class = "fas fa-caret-right accordion-icon mr-3" data-fa-transform = "shrink-2"></span><span class = "fw-medium font-sans-serif text-900">When to send?</span></button></div>
            <div class = "collapse" id = "collapseSix" aria-labelledby = "headingSix" data-parent = "#accordionExample">
            <div class = "card-body pt-2">
            <div class = "pl-0" style = "width: 250px;" id = "texttipbox" >Be conscious of the time. Will the email reach the curator’s inbox in the middle of the night? Will it get buried in the morning rush? The best times to send an email is around 10 a.m.
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>

            </div>

            <style>


            #gmailbtn
            {
            padding: inherit;
            background: #f14236;
            }
            #gmailbtn:hover
            {
            background: #ce3328;
            }
            @media (max-width: 1693px)
            {
            #texttipbox
            {
            width: 185px!important;
            }

            }


            @media (max-width: 767px)
            {
            #gmailbtn
            {
            display:none;
            }
            .flexereamobile
            {
            display: block!important;
            }
            #btnchangetitle
            { width: 43%!important;
            font-size: 10px;
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
            {display: flex;
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
                    /*$summernote.summernote({
                     placeholder: 'Write your message here',
                     height: 120,
                     toolbar: [
                     ['style', ['style']],
                     ['font', ['bold', 'underline', 'clear']],
                     ['color', ['color']],
                     ['para', ['ul', 'ol', 'paragraph']],
                     ]
                     });*/
                    tinymce.init({
                        selector: '#summernote',
                        menubar: false
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
                                console.log(text)
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
