<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpotifyUsers;
use App\Models\SpotifyBlacklistUsers;

/**
 * Description of SpotifyUsersController
 *
 * @author user
 */
class SpotifyUsersController extends Controller {

    //put your code here


    public function moveToWhitelist(Request $request) {
        $spotifyUserIDDB = $request->spotifyUserID;
        if (!$spotifyUserIDDB || $spotifyUserIDDB === "") {
            return response()->json(array('status' => 'error', 'message' => 'There was error in server'));
        }
        $spotifyBlacklistUser = SpotifyBlacklistUsers::where('id', '=', $spotifyUserIDDB)->get()->first();
        SpotifyUsers::updateOrCreate(
                ['spotify_user_id' => $spotifyBlacklistUser->spotify_user_id]
        );

        $spotifyBlacklistUser->delete();
        return response()->json(array('status' => 'success'));
    }

    public function moveToBlacklist(Request $request) {
        $spotifyUserIDDB = $request->spotifyUserID;

        if (!$spotifyUserIDDB || $spotifyUserIDDB === "") {
            return response()->json(array('status' => 'error', 'message' => 'There was error in server'));
        }
        $spotifyUser = SpotifyUsers::where('id', '=', $spotifyUserIDDB)->get()->first();

        SpotifyBlacklistUsers::updateOrCreate(
                ['spotify_user_id' => $spotifyUser->spotify_user_id]
        );

        $spotifyUser->delete();
        return response()->json(array('status' => 'success'));
    }

}
