<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SpotifyWebAPI;
//use googleclie
use Google_Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class SocialController extends Controller {

    public function loginWithGoogle(Request $request) {
        $tokenID = $request->tokenID;

        $tokenID = filter_var($tokenID, FILTER_SANITIZE_STRING);

        $googleClientID = Config('services.google.client_id');

        $client = new Google_Client(['client_id' => $googleClientID]);  // Specify the CLIENT_ID of the app that accesses the backend
//        $client = new Google_Client();  // Specify the CLIENT_ID of the app that accesses the backend
        $payload = $client->verifyIdToken($tokenID);

        if ($payload) {
            $googleUserID = $payload['sub'];
            $googleUserEmail = $payload['email'];
            $aud = $payload['aud'];
            $match = $aud === $googleClientID;


            if ($match) { // user authenticated
                $userID = $this->getUserIDByGoogleID($googleUserID);
                if ($userID) { // spotify ID exists - login user
                    Auth::loginUsingId($userID);
                    echo 11;
                    return;
                    return redirect('/');
                } else { // only email exists, register spotify_id and remove email verification
                    $user = $this->getUserByEmail($googleUserEmail);
                    if ($user) {
                        $user->email_verified_at = null;
                        $user->google_id = $googleUserID;
                        $user->save();
                        Auth::login($user);
                        echo 22;
                        return;
                        return redirect('/');
                    } else { // User not exists
                        $image = isset($payload['picture']) ? $payload['picture'] : false;
                        $user = $this->registerUser($payload['name'], $googleUserEmail, $image, 'google_id', $googleUserID);
                        echo 33;
                        return;
                        return redirect('/');
                    }
                }
            } else { // not our client ID
                echo "not good";
            }
            exit;
        } else {
            // Invalid ID token
        }
    }

    public function loginWithSpotify() {

        $session = new SpotifyWebAPI\Session(
                Config('services.spotify.main.client_id'),
                Config('services.spotify.main.client_secret'),
                'http://localhost:8000/spotify-login'
        );

        
        $api = new SpotifyWebAPI\SpotifyWebAPI();


        if (isset($_GET['code'])) {

            try {
                $session->requestAccessToken($_GET['code']);
                $api->setAccessToken($session->getAccessToken());

//                $api->addPlaylistTracks('2oOZ9Z8YhR9KLwE9aRrQFH', '4O5c8T9I55IZr1hEUQrEGi');
//                $api->followPlaylist("3cg7YbnBt8t4ZoBz2zWcLC");
//                $api->next();
//                echo "<pre>";
//                exit;
//                print_r($api->getMyCurrentPlaybackInfo());
//                echo "ok";
//                exit;
            } catch (SpotifyWebAPI\SpotifyWebAPIAuthException $ex) {
//                var_dump($ex->getMessage());


                return redirect('/spotify-login');
            } catch (\Throwable $ex) {

//                var_dump($ex->getMessage());

                return redirect('/');
            }
//            echo "<pre>";
//            print_r($api->me());
            $spotifyUserDetails = $api->me();


            $userID = $this->getUserIDBySpotifyID($spotifyUserDetails->id);
            if ($userID) { // spotify ID exists - login user
                Auth::loginUsingId($userID);
                return redirect('/');
            } else { // only email exists, register spotify_id and remove email verification
                $user = $this->getUserByEmail($spotifyUserDetails->email);
                if ($user) {
                    $user->email_verified_at = null;
                    $user->spotify_id = $spotifyUserDetails->id;
                    $user->save();
                    Auth::login($user);
                    $user->insertSpotifyArtistID($spotifyUserDetails->id);
                    return redirect('/');
                } else { // User not exists
                    $image = isset($spotifyUserDetails->images[0]->url) ? $spotifyUserDetails->images[0]->url : false;
                    $user = $this->registerUser($spotifyUserDetails->display_name, $spotifyUserDetails->email, $image, 'spotify_id', $spotifyUserDetails->id);
                    $user->insertSpotifyArtistID($spotifyUserDetails->id);
                    return redirect('/');
                }
            }
            exit;
        } else {
            $options = [
                'scope' => [
                    'user-read-email',
                    'playlist-modify-public',
                    'streaming',
                    'user-read-private',
                    'user-read-playback-state',
                    'user-follow-read',
                    'user-read-recently-played'
                ],
            ];

            header('Location: ' . $session->getAuthorizeUrl($options));
            die();
        }
    }

//    private function isSptofiyUserExists($email, $key, $value) {
    private function getUserIDBySpotifyID($spotifyID) {
        $user = User::where('spotify_id', $spotifyID)->get()->first();
        return $user ? $user->id : false;
    }

    private function getUserIDByGoogleID($googleID) {
        $user = User::where('google_id', $googleID)->get()->first();
        return $user ? $user->id : false;
    }

    private function getUserByEmail($email) {
        $user = User::where('email', $email)->get()->first();
//        return $user ? $user->id : false;
        return $user;
    }

    private function registerSpotifyUser($spotifyData) {
        
    }

    private function registerUser($name, $email, $image = false, $key, $value) {


        $userExists = false;

        $userDetails = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make(Str::random(16)),
            'avatar' => $image ? $image : null,
            'email_verified_at' => now()->timestamp
        ];

        $userDetails[$key] = $value;



        Auth::login($user = User::create($userDetails));
        event(new Registered($user));

        return $user;
    }

}
