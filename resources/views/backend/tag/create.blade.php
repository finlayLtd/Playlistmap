@extends('backend.tag.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Tags</a>
@endsection
@section('breadcrumb-active', 'Create')

@section('form-heading', 'Add Tag')

@section('route', route('backend.tags.store'))

@section('form-fields')
    @include('backend.tag.fields')
@endsection
