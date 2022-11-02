<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotifyBlacklistUsers extends Model {

    protected $table = 'spotify_blacklist_users';
    protected $fillable = [
        'id', 'spotify_user_id'
    ];

    

}
