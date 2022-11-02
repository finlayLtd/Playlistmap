<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpotifyArtistsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('spotify_artists', function (Blueprint $table) {
            $table->id();
            $table->string('artist_id');
            $table->string('name');
            $table->string('image');
            $table->integer('followers')->unsigned();
            $table->string('genres');
            $table->integer('popularity')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('spotify_artists');
    }

}
