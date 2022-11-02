<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Lib\SpotifyController;

class CuratorController extends Controller {

    public function getPlaylistPage(Request $request, $playlistID) {

        if (!$playlistID || $playlistID === "") {
            abort(403);
        }

        $playlist = Playlist::where('playlist_id', $playlistID)->get()->first();
        if (!$playlist) {
            abort(403);
        }
        $spotifyController = new SpotifyController();

//        echo "<pre>";
        try {
            $userID = $playlist->user_id;
            $user = $spotifyController->doSpotifyRequest("users/{$userID}");
            $userImage = isset($user['images'][0]['url']) ? $user['images'][0]['url'] : false;
//            print_r($user);
        } catch (\Throwable $ex) {
            abort(403);
        }


//        var_dump($playlist);
        $accessToken = "BQANsF2k6QDX9J67DdcB401oFIba0T9KoFj0XBMOneJ_lq4OdbreBMwchu7hteZf2EY8uPKxrybVBhpNg9E";
//$accessToken = $this->getTestAccessToken();
        return view('pages.curator-playlist', ['user' => $user, 'userImage' => $userImage, 'accessToken' => $accessToken]);
        exit;

//        var_dump($playlistID);
//        echo 333;
//        exit;
//        $user = auth()->user();
//        $playlists = $user->unlockedPlaylists()->paginate(25);
//
//        return view('frontend.profile.index', compact('user', 'playlists'));
    }

    private function getTestAccessToken() {

        $apiKey = "8155cf8601614fce8f3a696e3230356a";
        $secret = "3a4d5a0b2cf94fd7a940b981c361adfb";
        try {
            $client = new \GuzzleHttp\Client();
            $spotifyApiTokenURL = "https://accounts.spotify.com/api/token";
            $response = $client->post($spotifyApiTokenURL, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Accepts' => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode($apiKey . ':' . $secret),
                ],
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]);
        } catch (RequestException $e) {
            var_dump('Spotify Exceptionn');
            exit;
            //throw new SpotifyAuthException($message, $status, $errorResponse);
        }
//        Log::channel('spotify_api')->info('Successfully generated new access token');
        $body = json_decode((string) $response->getBody());


        $accessToken = $body->access_token;
        return $accessToken ? $accessToken : false;
        ;
//        var_dump('access_token');
//        var_dump($accessToken);
//        exit;
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,$user->id"
        ]);

        $user->update($request->except(['password', 'avatar']));
        $user->uploadImage('avatar', 'images/users');
        if ($password = $request->input('password'))
            $user->update(['password' => bcrypt($password)]);
        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    public function plans() {
        $data = array();

        $user = auth()->user();
        $plans = Plan::all();

        $data['user'] = $user;
        $data['plans'] = $plans;
        $data['subscription'] = $user->subscription();
        $data['chosen_plan_id'] = $user->subscription()->plan_id;

        try {
            $currentUsageCredits = $user->subscription()->getUsageByFeatureAndPlan($user->subscription()->plan, 'credits');

            $data['valid_until'] = $currentUsageCredits->valid_until->subDays(1);
        } catch (\Throwable $ex) {
            $data['valid_until'] = Carbon::now()->addDays(30);
        }
        $this->checkForStripeID();


        if ($user->subscription()->change_to_free_plan !== null) {
            $freePlan = Plan::whereSlug('free')->firstOrFail();
            if ($freePlan) {
                $data['chosen_plan_id'] = $freePlan->id;
            }
        }
        return view('frontend.profile.plan_management', $data);
    }

    private function checkForStripeID() {
        $stripeID = config('services.stripe.key');
        if (!$stripeID) {
            try {
                $user = auth()->user();
                $response = Http::asForm()->post(config('services.integromat.users_cant_pay'), [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'message' => "There is no stripe ID in manage-plans view",
                    'url' => url()->full()
                ]);
            } catch (\Thorwable $ex) {
                return;
            }
        }
    }

    public function updateArtistID(Request $request) {
        $user = auth()->user();


        $request->validate([
            'artistID' => 'required|string',
            'artistImage' => 'url|nullable',
            'artistName' => 'string|nullable',
        ]);

        $user->avatar = $request->artistImage;

        if (isset($request->artistName) && $request->artistName !== "") {
            $user->name = $request->artistName;
        }

        $user->save();

        UsersData::updateOrCreate(
                ['user_id' => $user->id],
                ['spotify_artist_id' => $request->artistID]
        );

        return json_encode(["status" => "success"]);
        exit;
    }

}
