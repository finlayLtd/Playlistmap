@extends('backend.layouts.master')

@section('title', 'Plans')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Plans</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
    <x-errors/>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Manage Plans</h3>
            <div class="block-options">

            </div>
        </div>
        <div class="block-content">
            <form action="{{ route('backend.plans.update') }}" method="post">
                <div class="row py-30">
                    @csrf
                    @foreach($plans as $plan)
                        <x-plan-builder :plan="$plan"/>
                    @endforeach
                    <div class="col-12 text-right">
                        <button class="btn btn-primary">Update Plans</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
