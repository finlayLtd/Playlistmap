@extends('backend.layouts.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Users</a>
@endsection
@section('breadcrumb-active', 'Create')

@section('form-heading', 'Add User')

@section('route', route('backend.users.store'))

@section('form-fields')
    @include('backend.user.fields')
@endsection
