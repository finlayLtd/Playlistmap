@extends('backend.layouts.master')

@section('title', 'Subscriptions')

@section('breadcrumbs')
    <a class="breadcrumb-item" href="javascript:void(0)">Subscriptions</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">{{ $subscriptions->count() }} Subscriptions Total</h3>
            <div class="block-options">

            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-striped table-vcenter">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Starts At</th>
                        <th>Renews At</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td>
                                {{ $subscription->user->name }} <br>
                                {{ $subscription->user->email }}
                            </td>
                            <td>{{ $subscription->plan->name }}<br>${{$subscription->plan->price}}</td>
                            <td>{{ $subscription->starts_at->format('d F, Y h:i A') }}</td>
                            <td>{{ $subscription->ends_at->format('d F, Y h:i A') }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button data-toggle="modal" data-target="#confirm_subscription_{{$subscription->id}}" class="btn btn-sm btn-outline-danger" title="">
                                        <i class="fa fa-ban"></i></button>
                                    @include('backend.includes.modals.confirm', ['model' => 'subscription', 'route' => route('backend.subscriptions.destroy', $subscription), 'form' => true])
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
                    {{ $subscriptions->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
