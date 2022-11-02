@extends('backend.layouts.master')

@section('title', 'Templates')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Templates</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Templates List</h3>
            <div class="block-options">

            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Subject</th>
                        <th>Body</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($templates as $template)
                        <tr>
                            <td>{{ $template->id }}</td>
                            <td>{{ $template->subject }}</td>
                            <td>{{ strip_tags($template->body) }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('backend.templates.show', $template->id) }}" class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" title="View">
                                        <i class="fal fa-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.templates.edit', $template->id) }}" class="btn btn-sm btn-secondary"
                                       data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <button data-toggle="modal" data-target="#confirm_template_{{$template->id}}" class="btn btn-sm btn-outline-danger" title="">
                                        <i class="fa fa-trash"></i></button>
                                    @include('backend.includes.modals.confirm', ['model' => 'template', 'route' => route('backend.templates.destroy', $template->id), 'form' => true])
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="999" class="text-center">{{ config('constants.no_record') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="pagination justify-content-center">
                    {{ $templates->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
