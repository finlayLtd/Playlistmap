@extends('backend.template.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Templates</a>
@endsection
@section('breadcrumb-active', 'Update')

@section('form-heading', 'Update Template')

@section('route', route('backend.templates.update', $template->id))

@section('form-fields')
    @method('put')
    @include('backend.template.fields')
@endsection
