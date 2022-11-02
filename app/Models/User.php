<?php

namespace App\Models;

use App\Traits\UploadImage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Rinvex\Subscriptions\Models\PlanSubscription;
use Rinvex\Subscriptions\Traits\HasSubscriptions;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use \Stripe;
use App\Lib\SendgridController;
use App\Models\UsersData;
use Illuminate\Support\Facades\Auth;
use App\Lib\SpotifyController;

class User extends Authenticatable implements MustVerifyEmail {

    use HasFactory,
        Notifiable,
        HasRoles,
        UploadImage,
        HasSubscriptions;

    protected $fillable = ['stripe_id', 'paypal_id', 'name', 'email', 'password', 'avatar', 'status', 'avatar', 'spotify_id', 'google_id', 'email_verified_at'];
    protected $hidden = ['password', 'remember_token',];
    protected $dates = ['last_seen_at'];
    protected $casts = ['email_verified_at' => 'datetime',];

    public static function boot() {
        parent::boot();

        self::created(function ($user) {
            $user->newSubscription('primary', Plan::find(1));
            if (!$user->hasAnyRole(Role::all())) {
                $user->assignRole(2);
            }
            $sendgridController = new SendgridController();
            $sendgridController->createRecipient($user);
        });

        self::deleted(function ($user) {
            $user->subscriptions()->delete();
        });
    }

    public function unlockedPlaylists() {
        return $this->belongsToMany(Playlist::class, 'unlocked_playlists')->withPivot('created_at');
    }

    /** This function determine if user already unlocked a playlist from curator
     * 
     * @param type $playlist
     * @return boolean
     */
    public function alreadyUnlockedPlaylistFromThisCurator($playlist) {
        try {
            foreach (user()->unlockedPlaylists()->get() as $userPlaylist) { // get all unlocked playlists
                foreach ($playlist->contacts as $contact) {
                    if (in_array($contact, $userPlaylist->contacts)) { // check if contact is inside playlist
                        return true;
                    }
                }
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getAvatarUrlAttribute() {
        $path = false;
        if ($this->avatar && (file_exists($this->avatar) || filter_var($this->avatar, FILTER_VALIDATE_URL))) {
            $path = asset($this->avatar);
        }
        return $path;
    }

    public function getStatusTextAttribute() {
        return config("constants.user_statuses.$this->status");
    }

    public function getHasNoPlanAttribute() {
        return $this->subscription()->plan->isFree();
    }

    public function getRoleAttribute() {
        return $this->hasRole(1) ? 'Administrator' : 'User';
    }

    public function getHasAdminRightsAttribute() {
        return $this->hasRole(1);
    }

    public function getCreditsAttribute() {
        if ($this->subscription()->featureIsUnlimited('credits')) {
            return '∞';
        }

        return $this->subscription()->getFeatureRemainings('credits');
    }

    public function getSearchLimitAttribute() {
        if ($this->subscription()->featureIsUnlimited('search_limit')) {
            return '∞';
        }

        return $this->subscription()->getFeatureRemainings('search_limit');
    }

    public function subscription(string $subscriptionSlug = 'primary'): ?PlanSubscription {
        return $this->subscriptions->where('name', $subscriptionSlug)->first();
    }

    public function createStripeAccount() {
        if ($this->stripe_id) {
            return false;
        }

        $customer = Stripe::customers()->create([
            'email' => $this->email,
        ]);

        $this->update([
            'stripe_id' => $customer['id']
        ]);

        return true;
    }

    public function getStripeAccountAttribute() {
        if (!$this->stripe_id) {
            $this->createStripeAccount();
        }
        return Stripe::customers()->find($this->stripe_id);
    }

    public function insertSpotifyArtistID($spotifyArtistID) {
        $user = Auth::user();
        if (!$spotifyArtistID || !$user) {
            return;
        }

        $currentUserData = UsersData::where('spotify_artist_id', $spotifyArtistID)->get()->first();
        if ($currentUserData) {//UsersData already exists
            return true;
        }

        $userData = new UsersData();


        try {
            $genres = $this->getArtistGenres($spotifyArtistID);
        } catch (Exception $ex) {
            $genres = false;
        }
        if ($genres) {
            $userData->genres = $genres;
        }
        $userData->user_id = $user->id;
        $userData->spotify_artist_id = $spotifyArtistID;
        $userData->save();

        return;
    }

    private function getArtistGenres($spotifyArtistID) {
        $spotifyController = new SpotifyController();
        $artistOBJ = $spotifyController->doSpotifyRequest("artists/{$spotifyArtistID}");
        if (!$artistOBJ) {
            return false;
        }

        $genres = isset($artistOBJ['genres']) ? $artistOBJ['genres'] : false;

        return $genres;
    }

}
