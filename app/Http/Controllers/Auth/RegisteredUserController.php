<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\ValidEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UsersData;
use Illuminate\Support\Facades\Validator;


class RegisteredUserController extends Controller {

    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create() {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request) {
        
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => ['required', ' string', ' email', ' max:255', ' unique:users', new ValidEmail],
                'password' => 'required|string|confirmed|min:8',
                'agree' => 'required|accepted',
                'spotify-artist-id' => 'string|nullable',
                'spotify-artist-image' => 'url|nullable'
                    ], [
                'agree.required' => 'You must agree to our terms & conditions'
            ]
        );
        
        if($validator->fails()){
            return redirect()->back()->with('rgm',1)->withErrors($validator);
        }

        Auth::login($user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'avatar' => $request['spotify-artist-image']
        ]));
        
        // event(new Registered($user));
        
        $request->user()->sendEmailVerificationNotification();
        $user->insertSpotifyArtistID($request['spotify-artist-id']);
        //    $user->uploadProfileImageFromURL($request['spotify-artist-image']);

        return redirect(RouteServiceProvider::HOME);
    }

    public function insertSpotifyID($spotifyArtistID) {
        $user = Auth::user();
        echo "<pre>";
        var_dump($user);
        var_dump($spotifyArtistID);
        exit;
        
        if (!$spotifyArtistID || !$user) {
            return;
        }


        $userData = new UsersData();

        $userData->user_id = $user->id;
        $userData->spotify_artist_id = $spotifyArtistID;
        $userData->save();

        return;
    }

}
