<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistCrawlerWord extends Model {

    protected $table = 'playlists_crawler_words';
    protected $fillable = [
        'id', 'query', 'status', 'priority', 'total_new_words', 'total_new_playlists','comments', 'created_at', 'updated_at'
    ];
 
}
