@extends('backend.layouts.form')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Users</a>
@endsection
@section('breadcrumb-active', 'Update')

@section('form-heading', 'Update User')

@section('route', route('backend.users.update', $user->id))

@section('form-fields')
    @method('put')
    @include('backend.user.fields')
@endsection
