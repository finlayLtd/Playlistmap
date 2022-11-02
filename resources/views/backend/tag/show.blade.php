@extends('backend.layouts.master')

@section('title', 'Tags')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Tags</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
   <div class="row">
       <div class="col-md-12">
           <div class="block">
               <div class="block-header block-header-default">
                   <div class="block-title">Tag Preview</div>
                   <div class="block-options">
                       <a href="{{ route('backend.tags.edit', $tag->id ) }}" class="btn-block-option">
                           <i class="fal fa-pencil"></i>
                       </a>
                   </div>
               </div>
               <div class="block-content">
                   <table class="table table-borderless  table-vcenter">
                       <tr>
                           <th scope="row" style="width: 10%">Subject</th>
                           <td>{{ $tag->subject }}</td>
                       </tr>
                       <tr>
                           <th scope="row" style="width: 10%">Body</th>
                           <td>{!! $tag->body !!}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>
@endsection
