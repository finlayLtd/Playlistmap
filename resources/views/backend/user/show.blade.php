@extends('backend.layouts.master')

@section('title', 'Users')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Users</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
   <div class="row">
       <div class="col-md-12">
           <div class="block">
               <div class="block-header block-header-default">
                   <div class="block-title">{{ $user->name }}</div>
                   <div class="block-options">
                       <a href="{{ route('backend.users.edit', $user->id ) }}" class="btn-block-option">
                           <i class="fal fa-pencil"></i>
                       </a>
                   </div>
               </div>
               <div class="block-content">
                   <table class="table table-borderless  table-vcenter">
                       @foreach($user->getFillable() as $column)
                           <tr>
                               <th scope="row">{{ \Illuminate\Support\Str::title($column) }}</th>
                               <td>{{ $user->{$column} }}</td>
                           </tr>
                       @endforeach
                   </table>
               </div>
           </div>
       </div>
   </div>
@endsection
