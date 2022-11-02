@extends('backend.layouts.master')

@section('title', 'Playlists')

@section('breadcrumbs')
<a class="breadcrumb-item" href="javascript:void(0)">Playlists</a>
@endsection
@section('breadcrumb-active', 'Index')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="block">
            <div class="block-header block-header-default">
                <div class="block-title">{{ $playlist->name }}</div>
                <div class="block-options">
                    <a href="{{ route('backend.playlists.edit', $playlist->id ) }}" class="btn-block-option">
                        <i class="fal fa-pencil"></i>
                    </a>
                </div>
            </div>
            <div class="block-content">
                <table class="table border-bottom border-yellow-900 table-vcenter">
                    @foreach($playlist->getFillable() as $column)

                    <tr>
                        <th scope="row">{{ \Illuminate\Support\Str::title($column) }}</th>
                        @if(in_array($column, ['artists', 'genres']))
                        <td>
                            @foreach($playlist->{$column} as $value) <span
                                class="badge badge-info">{{ $value }}</span>
                            @endforeach
                        </td>
                        @elseif($column == 'contacts')
                        <td>
                            @foreach($playlist->contacts as $contact)
                            <span class=" mr-2">{{ $contact }}</span>
                            @endforeach
                        </td>
                        @elseif($column == 'top_artists')
                        <td>
                            @foreach($playlist->top_artists as $artist => $value) <span
                                class="badge badge-pill badge-success">{{ $artist }} : {{ $value }}</span>
                            @endforeach
                        </td>
                        @elseif($column == 'moodiness')
                        <td>
                            @foreach($playlist->moodiness as $mood => $value)
                            {{ ucfirst($mood) }}
                            <div class="progress mb-4 position-relative" data-label="{{$playlist->moodValue($value)}}%">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{$playlist->moodValue($value)}}%; background-color: {{ $playlist->moodColor($mood) }}">
                                </div>
                            </div>
                            @endforeach
                        </td>
                        @elseif($column == 'all_artists' && $playlist->all_artists && count($playlist->all_artists) > 0)
                        <td>
                            @foreach($playlist->all_artists as $artist => $value) <span
                                class="badge badge-pill badge-success">{{ $artist }} : {{ $value }}</span>
                            @endforeach
                        </td>
                        @elseif($column == 'data')
                        <td></td>
                        @else
                        <td>{{ $playlist->{$column} }}</td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
