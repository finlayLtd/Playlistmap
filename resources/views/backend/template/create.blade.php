@extends('backend.template.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Templates</a>
@endsection
@section('breadcrumb-active', 'Create')

@section('form-heading', 'Add Template')

@section('route', route('backend.templates.store'))

@section('form-fields')
    @include('backend.template.fields')
@endsection
