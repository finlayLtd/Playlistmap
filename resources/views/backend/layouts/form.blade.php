@extends('backend.layouts.master')

@section('breadcrumb-title')
    @yield('active-breadcrumb', 'Form')
@endsection

@section('breadcrumb-item')
    <li class="breadcrumb-item">@yield('index-breadcrumb', 'Index')</li>
    <li class="breadcrumb-item active">@yield('active-breadcrumb', 'Form')</li>
@endsection

@section('content')
    <div class="block">
        <div class="block-header block-header-default">@yield('form-heading', 'Form')</div>
        <div class="block-content">
            <form action="@yield('route')" method="POST" enctype="multipart/form-data">
                @csrf
                @yield('form-fields')
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-success btn-sm">@yield('submit-text', 'Submit')</button>
                </div>
            </form>
        </div>
    </div>
@endsection
