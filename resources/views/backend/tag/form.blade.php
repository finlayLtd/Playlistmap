@extends('backend.layouts.form')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/summernote/summernote.css') }}">
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>

    <script>
        jQuery(function () {
            Codebase.helper('summernote', {});
        });
        let $summernote = $('#summernote');


        $('.placeholder').click(function () {
            let placeholder = $(this).html();
            console.log($summernote.summernote('text'));
            $summernote.summernote('insertText', ` %%${placeholder}%% `);
        });
    </script>
@endsection
