<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Playlist;

class PlaylistCrawler extends Model {

    protected $table = 'playlists_crawler';
    protected $fillable = [
        'id', 'spotify_id', 'status', 'removal_reason', 'contacts','spotify_user_id', 'data', 'updated_at'
    ];
    protected $casts = [
        'data' => 'array'
//        'contacts' => 'array'
    ]; 

    public function checkPlaylist() {
        $exists = $this->isPlaylistExists();

        $error = "All good";
        $status = "success";

        if ($this->isPlaylistExists()) {
            $status = 'error';
            $error = 'Playlist exists';
        } else {
//            $spotifyDetails = getSpotify
        }



        var_dump("Status: " . $status);
        var_dump("Message: " . $error);
    }

    private function isPlaylistExists() {
        $playlist = Playlist::where('playlist_id', '=', $this->spotify_id)->get();
        return count($playlist) === 1;
    }

}
