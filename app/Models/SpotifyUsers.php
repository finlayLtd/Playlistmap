<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpotifyUsers extends Model {

    protected $table = 'spotify_users';
    protected $fillable = [
        'id', 'spotify_user_id', 'spotify_user_name', 'source', 'contacts'
    ];
    protected $casts = [
//        'contacts' => 'array',
    ];

}
