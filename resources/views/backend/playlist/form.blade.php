@extends('backend.layouts.form')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/summernote/summernote.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/bs-tagsinput/tagsinput.css') }}">
@endsection

@section('scripts')
    <script src="{{asset('js/plugins/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('js/plugins/bs-tagsinput/tagsinput.js')}}"></script>

    <script>
        jQuery(function () {
            Codebase.helper('summernote');
        });
    </script>
@endsection
