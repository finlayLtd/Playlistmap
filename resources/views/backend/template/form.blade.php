@extends('backend.layouts.form')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/summernote/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/js/select2.min.js')}}"></script>

    <script>
        jQuery(function () {
            Codebase.helpers(['summernote', 'select2']);
        });
        let $summernote = $('#summernote');


        $('.placeholder').click(function () {
            let placeholder = $(this).html();
            $summernote.summernote('insertText', ` %%${placeholder}%% `);
        });
    </script>
@endsection
