<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnlockedPlaylistsTable extends Migration
{
    public function up()
    {
        Schema::create('unlocked_playlists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('playlist_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('unlocked_playlists');
    }
}
