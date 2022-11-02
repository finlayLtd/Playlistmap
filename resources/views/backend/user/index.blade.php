@extends('backend.layouts.master')

@section('title', 'Users')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Users</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Users List</h3>
            <div class="block-options">
                <button data-toggle="modal" data-target="#import_from_csv" class="btn-block-option " title="">
                    <i class="fal fa-download"></i></button>
            </div>
        </div>
        @include('backend.includes.modals.import')
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>User</th>
                        <th>Last Seen</th>
                        <th>Created</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Paying User</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <div class="media">
                                    <img class="img-avatar rounded mr-3" src="{{ $user->avatar_url }}" alt="">
                                    <div class="media-body align-self-center">
                                        <div class="font-w600 mb-5">{{ $user->name }}</div>
                                        <div class="font-size-sm text-muted">{{ $user->role }}</div>
                                    </div>
                                </div>

                            </td>
                            <td><x-friendly-date :date="$user->last_seen_at"/></td>
                            <td>{{ $user->created_at->format('d M, Y') }}</td>
                            <td>{{ $user->status_text }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->paying_user }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('backend.users.show', $user->id) }}" class="btn btn-sm btn-primary"
                                       data-toggle="tooltip" title="View">
                                        <i class="fal fa-eye"></i>
                                    </a>
                                    <a href="{{ route('backend.users.edit', $user->id) }}" class="btn btn-sm btn-secondary"
                                       data-toggle="tooltip" title="Edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <button data-toggle="modal" data-target="#confirm_user_{{$user->id}}" class="btn btn-sm btn-outline-danger" title="">
                                        <i class="fa fa-trash"></i></button>
                                    @include('backend.includes.modals.confirm', ['model' => 'user', 'route' => route('backend.users.destroy', $user->id), 'form' => true])
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
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
