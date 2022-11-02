@extends('backend.layouts.master')

@section('title', 'Tags')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Tags</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Tags List</h3>
            <div class="block-options">

            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Tag</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('backend.tags.show', $tag->id) }}" class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" title="View">
                                        <i class="fal fa-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.tags.edit', $tag->id) }}" class="btn btn-sm btn-secondary"
                                       data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <button data-toggle="modal" data-target="#confirm_tag_{{$tag->id}}" class="btn btn-sm btn-outline-danger" title="">
                                        <i class="fa fa-trash"></i></button>
                                    @include('backend.includes.modals.confirm', ['model' => 'tag', 'route' => route('backend.tags.destroy', $tag->id), 'form' => true])
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
                    {{ $tags->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
