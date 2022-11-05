@extends('layouts.frontend-main')

@section('content')
    @if(request()->query('q'))

<div class="card">
            <div class="card-header bg-100">
               <b style="    font-size: 24px;"> {{ $results_count }} </b>results found for "<b>{{request()->query('q')}}</b>"
            </div>
            <div class="card-body">
                @if($playlists->count())
                    <div class="alert alert-info text-center">
                        <h3  class="text-center">Create Account</h3>
                        <p>
                           Create a free account to view the search results. You're one click away from reaching your future fans!
                        </p>
                        <a id="btnguestsearch"  href="{{ route('register') }}" class="btn btn-sm btn-success">Start for free</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table border">
                            <thead>
                            <tr class="">
                                <th scope="col">Playlist Name</th>
                                <th scope="col">Followers</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">Top Artists</th>
                                <th scope="col">Top Genres</th>
                                <th scope="col">Contact Details</th>
                            </tr>
                            </thead>
                            <tbody class="premium-content">
                            @foreach($playlists as $playlist)
                                <tr>
                                    <td class="w-25">{{ $playlist->name }}</td>
                                    <td class="followers">{{ $playlist->formatted_followers }}</td>
                                    <td class="w-25">
                                        <x-friendly-date :date="$playlist->last_updated_on"/>
                                    </td>
                                    <td>
                                        @foreach(array_slice($playlist->artists, 0, 5) as $artist)
                                            <a class="hover-text-decoration-none"
                                               href="{{ route('frontend.search', ['q' => $artist]) }}">
                                                <span
                                                    class="badge badge-soft-info cursor-pointer">{{ $artist }}</span>
                                            </a>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach(array_slice($playlist->genres, 0, 5) as $genre)
                                            <a class="hover-text-decoration-none"
                                               href="{{ route('frontend.search', ['q' => $genre]) }}">
                                                <span
                                                    class="badge badge-soft-info cursor-pointer">{{ $genre }}</span>
                                            </a>
                                        @endforeach
                                    </td>
                                    <td class="">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-primary" type="button"> Unlock
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-4 ">
                        <h4 class="text-center text-muted">{{ $no_result_text }}</h4>
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection


@section('scripts')
    <script>
    </script>
@endsection
