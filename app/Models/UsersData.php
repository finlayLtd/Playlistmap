<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersData extends Model {

    protected $table = 'users_data';
    protected $fillable = [
        'id', 'user_id', 'spotify_artist_id', 'searches', 'genres'
    ];
    protected $casts = [
        'searches' => 'array',
        'genres' => 'array'
    ];

}
