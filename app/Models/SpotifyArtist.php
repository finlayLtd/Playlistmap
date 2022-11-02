<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotifyArtist extends Model {

    protected $table = 'spotify_artists';
    protected $fillable = [
        'id', 'artist_id', 'name', 'image', 'followers', 'genres', 'popularity'
    ];
    protected $casts = [
        'genres' => 'array',
    ];

}
