<?php

namespace App\Http\Controllers\Backend;

use App\Exports\PlaylistsExport;
use App\Http\Controllers\Controller;
use App\Imports\PlaylistsImport;
use App\Models\Playlist;
use App\Models\ReportedPlaylist;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spotify;
use Illuminate\Support\Facades\Http;
use Log;
use App\Lib\SpotifyController;

class PlaylistController extends Controller {

    public function index() {
        $q = request()->query('q');
        $playlists = Playlist::whereAnyColumnLike($q)->latest()->paginate(25);

        return view('backend.playlist.index', compact('playlists'));
    }

    public function create() {
        return view('backend.playlist.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'playlist_id' => 'required|unique:playlists,playlist_id,',
            'user_id' => 'required',
            'moodiness.*' => 'required|numeric|min:0|max:1',
        ]);

        Playlist::create($request->all());

        return redirect()->route('backend.playlists.index')->with('success', 'Playlist Created Successfully');
    }

    public function import(Request $request) {
        $request->validate([
            'csv' => 'required'
        ]);

        $last_inserted_playlist = Playlist::latest('id')->first();
        $last_inserted_playlist_id = $last_inserted_playlist ? $last_inserted_playlist->id : 0;

        $file = request()->file('csv');
        Excel::import(new PlaylistsImport(), $file);

        $number_of_imported_rows = Playlist::where('id', '>', $last_inserted_playlist_id)->count();
        return redirect()->back()->with('success', $number_of_imported_rows . " Playlists Imported");
    }

    public function export() {
        return Excel::download(new PlaylistsExport(), 'playlists.xlsx');
    }

    public function show(Playlist $playlist) {
        return view('backend.playlist.show', compact('playlist'));
    }

    public function edit(Playlist $playlist) {
        return view('backend.playlist.edit', compact('playlist'));
    }

    public function update(Request $request, Playlist $playlist) {
        $request->validate([
            'name' => 'required',
            'playlist_id' => 'required|unique:playlists,playlist_id,' . $playlist->id,
            'user_id' => 'required',
            'moodiness.*' => 'required|numeric|min:0|max:1',
        ]);

        $playlist->update($request->except('playlist_id'));

        return redirect()->back()->with('success', 'Playlist Updated Successfully');
    }

    public function destroy(Playlist $playlist) {
        $playlist->delete();
        return redirect()->back()->with('success', 'Playlist Deleted Successfully!');
    }

    public function reportedPlaylists() {
        $reportedPlaylists = ReportedPlaylist::paginate(25);
        return view('backend.playlist.reported_playlists', compact('reportedPlaylists'));
    }

    public function updatePlaylistFromSpotify() {
        Log::channel('spotify_playlists_updating')->info('Update playlists cron waking up!');
        $playlists = Playlist::orderBy('updated_at', 'asc')->take(100)->get();
        $updatedPlaylist = 0;
        $spotifyController = new SpotifyController();

        foreach ($playlists as $key => $playlist) {
            try {
//                $res = Spotify::playlist($playlist->playlist_id)->get();
                $res = $spotifyController->doSpotifyRequest("playlists/{$playlist->playlist_id}");
            } catch (\Throwable $e) {
                Log::channel('spotify_playlists_updating')->info('Spotify error exception - ' . $e->getMessage(), ['playlistID' => $playlist->playlist_id]);
                if ($e->getMessage() === "API rate limit exceeded") {
                    Log::channel('spotify_playlists_updating')->info("Total playlists updated: {$updatedPlaylist}");
                    Log::channel('spotify_playlists_updating')->info('Spotify rate limit exceeded - exit cron', ['playlistID' => $playlist->playlist_id]);
                    return;
                }
                continue;
            }

            if (!$res) { // deleted playlists
                $playlist->touch();
                continue;
            }

            if(!isset($res['tracks'])){
                continue;
            }

            $tracks = $res['tracks'];
            $followers = $res['followers']['total'];
            $tracksTotal = $res['tracks']['total'];
            $name = $res['name'];
            $image = null;
            
            
            if (isset($res['images'][0]['url'])) {
                $image = $res['images'][0]['url'];
            }

            try {
                $result = $this->getMostUpdatedTrackDateAndArtists($tracks, $playlist->playlist_id);
                if(!isset($result['date'])){
                    continue;
                }
            } catch (Exception $ex) {
                $playlist->touch();
                continue;
            }


            $dateOnly = explode('T', $result['date'])[0];
            
            $data = [
                'name' => $name,
                'number_of_tracks' => $tracksTotal,
                'followers' => $followers,
                'last_updated_on' => $dateOnly,
                'image' => $image
            ];
            
            if(isset($result['artists'])){
                $data['all_artists'] = $result['artists'];
            }
            
            $isUpdated = $playlist->update($data);
//            $isUpdated = $playlist->update([
//                'name' => $name,
//                'number_of_tracks' => $tracksTotal,
//                'followers' => $followers,
//                'last_updated_on' => $dateOnly,
//                'all_artists' => isset($result['artists']) ? $result['artists'] : [],
//                'image' => $image
//            ]);
            if ($isUpdated) {
                $playlist->touch();
                $updatedPlaylist++;
            }

            $this->updatePlaylistData($playlist, $followers, $tracksTotal);
        }
        Log::channel('spotify_playlists_updating')->info("Total playlists updated: {$updatedPlaylist}");
        var_dump("Total playlists updated: {$updatedPlaylist}");
        exit;
    }

    private function updatePlaylistData($playlist, $followers, $numberOfTracks) {
        if (!$playlist->data) {
            $playlist->data = [
                'statistics' => [
                    'followers' => [
                        [
                            'timestamp' => time(),
                            'value' => $followers
                        ]
                    ],
                    'tracks' => [
                        [
                            'timestamp' => time(),
                            'value' => $numberOfTracks
                        ]
                    ],
                ]
            ];
        } else {
            $data = $playlist->data;

            $data['statistics']['followers'][] = [
                'timestamp' => time(),
                'value' => $followers
            ];
            $data['statistics']['tracks'][] = [
                'timestamp' => time(),
                'value' => $numberOfTracks
            ];

            $playlist->data = $data;
        }

        $playlist->save();

        return;
    }

    private function getMostUpdatedTrackDateAndArtists($tracks, $playlist_id) {
        $mostUpdatedTrack = "1970-01-01T02:52:16Z";
        $totalTracks = 0;
        $i = 1;
        $artists = [];

        while (true) {
            foreach ($tracks['items'] as $key => $track) {
                try {
                    foreach ($track['track']['artists'] as $artist) {
                        if (!in_array($artist['name'], $artists)) { // check if artists not exists
                            if($artist['name'] === "" || $artist['id'] === null){
                                continue;
                            }
                            $artists[$artist['name']] =  $artist['id']; // add to artists new artists
                        }
                    }
                } catch (\Throwable $ex) {
                    
                }

                $totalTracks++;
                if ($track['added_at'] > $mostUpdatedTrack) {
                    $mostUpdatedTrack = $track['added_at'];
                }
            }
            if ($tracks['next']) {
                try {
                    $tracks = Spotify::playlistTracks($playlist_id)->offset($i++ * 100)->get();
                } catch (\Throwable $e) {
                    Log::channel('spotify_playlists_updating')->info('Spotify error exception - ' . $e->getMessage());
                    return false;
                }
            } else {
                break;
            }
        }
        ksort($artists);
//        echo "<pre>";
//        print_r($artists);
//        ksort($artists);
//        print_r($artists);
//        exit;
//        ksort($artists);
        return array(
            'date' => $mostUpdatedTrack,
            'artists' => $artists
        );
    }

}
