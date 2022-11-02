@extends('backend.layouts.master')
@section('title', 'Reported Playlists')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Playlists</a>
@endsection
@section('breadcrumb-active', 'Reported')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Reported Playlists</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th class="w-25">Playlist ID</th>
                          <th>Email</th>
                        <th>User</th>
                         <th>Report User Id</th>
                        <th>id of playlist curator</th>
                        <th>Message</th>
                        <th class="text-right">Reported</th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($reportedPlaylists as $report)
                        <tr>
                            <td>{{ $report->id }}</td>
                            <td>{{ $report->playlist->playlist_id }}</td>
                            <td>{{ $report->user->email }}</td>
                            <td>{{ $report->user->name }}</td>
                            <td>{{ $report->user->id }}</td>
                            <td>{{ $report->playlist->user_id }}</td>
                            <td>{{ $report->message }}</td>
                            <td class="text-right">{{ $report->created_at->diffForHumans() }}</td>

                            <td class="text-center">
                                <div class="btn-group">
                                    <button data-toggle="modal" data-target="#confirm_report_{{$report->id}}" class="btn btn-sm btn-outline-danger" title="">
                                        <i class="fa fa-trash"></i></button>
                                    @include('backend.includes.modals.confirm', ['model' => 'report', 'route' => route('backend.reported-playlists.destroy', $report->id), 'form' => true])
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
                    {{ $reportedPlaylists->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
