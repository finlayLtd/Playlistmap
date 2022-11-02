@extends('backend.layouts.master')

@section('title','Dashboard')

@section('content-heading', 'Dashboard')

@section('content')

<h2>Users statistics</h2>
@foreach ($data as $row)

<div class="col-md-4">
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item col-md-6">{{$row['label']}}:</li>
        <li class="list-group-item col-md-6 list-group-item-info">{{$row['value']}}</li>
    </ul>
</div>
@endforeach

@endsection
