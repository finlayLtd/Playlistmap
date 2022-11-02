@extends('backend.layouts.master')

@section('title', 'Templates')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Templates</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
   <div class="row">
       <div class="col-md-12">
           <div class="block">
               <div class="block-header block-header-default">
                   <div class="block-title">Template Preview</div>
                   <div class="block-options">
                       <a href="{{ route('backend.templates.edit', $template->id ) }}" class="btn-block-option">
                           <i class="fal fa-pencil"></i>
                       </a>
                   </div>
               </div>
               <div class="block-content">
                   <table class="table table-borderless  table-vcenter">
                       <tr>
                           <th scope="row" style="width: 10%">Subject</th>
                           <td>{{ $template->subject }}</td>
                       </tr>
                       <tr>
                           <th scope="row" style="width: 10%">Body</th>
                           <td>{!! $template->body !!}</td>
                       </tr>
                   </table>
               </div>
           </div>
       </div>
   </div>
@endsection
