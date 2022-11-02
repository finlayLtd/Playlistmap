@extends('backend.tag.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Tags</a>
@endsection
@section('breadcrumb-active', 'Update')

@section('form-heading', 'Update Tag')

@section('route', route('tags.update', $tag->id))

@section('form-fields')
    @method('put')
    @include('backend.tag.fields')
@endsection
