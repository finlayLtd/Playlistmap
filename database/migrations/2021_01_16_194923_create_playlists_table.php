<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->id();
            $table->string('playlist_id')->nullable();
            $table->text('name')->nullable();
            $table->text('description')->nullable();
            $table->string('user_id')->nullable();
            $table->string('number_of_tracks')->nullable();
            $table->string('owner')->nullable();
            $table->text('contacts')->nullable();
            $table->text('artists')->nullable();
            $table->unsignedBigInteger('followers')->nullable();
            $table->date('last_updated_on')->nullable();
            $table->text('top_artists')->nullable();
            $table->text('genres')->nullable();
            $table->text('moodiness')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('playlists');
    }
}
