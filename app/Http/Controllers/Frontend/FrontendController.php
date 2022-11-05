<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Playlist;
use App\Models\ReportedPlaylist;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Matrix\trace;
use App\Lib\SpotifyController;
use App\Models\UsersData;
use Illuminate\Support\Facades\Auth;
use \Stripe;

class FrontendController extends Controller {

    public function index() {
        
    }

    public function search() {
        $data = array();

        $user = auth()->user();

        $q = \request('q', '');
        $q = filter_var($q, FILTER_SANITIZE_STRING);



        $sortBy = \request('sortBy', '');

        $sortBy = filter_var($sortBy, FILTER_SANITIZE_STRING);

        $sortByAsc = \request('sortByAsc', '');
        $sortByAsc = filter_var($sortByAsc, FILTER_SANITIZE_STRING);
        $searchable_columns = ['name', 'genres', 'artists', 'all_artists'];
        $playlists = collect(new Playlist);

        if ($q) {
            $this->addSearchToUser($q);
            if ($sortBy || $sortByAsc) {
                $playlists = Playlist::whereAnyColumnLike($q, $searchable_columns);
            } else {
                $playlists = Playlist::whereAnyColumnLike($q, $searchable_columns);

                if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
                    $playlists = $playlists->get();

                    foreach ($playlists as $key => $playlist) {
                        $playlist = $playlist->calculatePlaylistScore($q);
//                        $playlist = $playlist->calculatePlaylistScore($q);
                    }

                    $playlists = $playlists->sortByDesc(function($item) {
                        return $item->playlist_score;
                    });



                    foreach ($playlists as $playlist) {
                        echo '<pre>';
                        var_dump('*************************************');
                        var_dump('Playlist id: ' . $playlist->playlist_id);
                        var_dump('Playlist name: ' . $playlist->name);
                        var_dump('Playlist score: ' . $playlist->playlist_score);
                    }
                    exit;
                }



//                $playlists = Playlist::whereAnyColumnLike($q, $searchable_columns)->inRandomOrder();
            }
            $unlockedPlaylistID = false;

            $data['currentUnlockedPlaylist'] = false;

            if (!$user->subscription()->plan->isFree()) {
                try {
                    if ($sortBy) {
                        if ($sortBy === "followers") {
                            $playlists->orderBy('followers', 'desc');
                        } else if ($sortBy === "tracks") {
                            $playlists->orderBy('number_of_tracks', 'desc');
                        } else if ($sortBy === "lastUpdated") {
                            $playlists->orderBy('last_updated_on', 'desc');
                        }
                    }
                } catch (Exception $ex) {
                    
                }

                try {
                    if ($sortByAsc) {
                        if ($sortByAsc === "followers") {
                            $playlists->orderBy('followers', 'asc');
                        } else if ($sortByAsc === "tracks") {
                            $playlists->orderBy('number_of_tracks', 'asc');
                        } else if ($sortByAsc === "lastUpdated") {
                            $playlists->orderBy('last_updated_on', 'asc');
                        }
                    }
                } catch (Exception $ex) {
                    
                }
            }

            if (session()->get('currentUnlockedPlaylistId')) {
                $unlockedPlaylistID = session()->get('currentUnlockedPlaylistId');
                $playlist = Playlist::where("playlist_id", "=", $unlockedPlaylistID)->get()->first();
                if ($playlist) {
                    $data['currentUnlockedPlaylist'] = $playlist;
                }
            }

            $data['results_count'] = $playlists->count();


            if (!$sortBy && !$sortByAsc) { // sort by score
                $playlists = $playlists->get();
                foreach ($playlists as $playlist) {
                    $playlist = $playlist->calculatePlaylistScore($q);
                }

                $playlists = $playlists->sortByDesc(function($item) {
                    return $item->playlist_score;
                });

                if ($user->subscription()->plan->isFree()) {
                    $playlists = $playlists->take(7);
                } else {
                    $page = isset(request()->page) ? request()->page : 1;
                    $perPage = 12;
                    $playlists = new \Illuminate\Pagination\LengthAwarePaginator(
                            $playlists->forPage($page, $perPage),
                            $playlists->count(),
                            $perPage,
                            $page
                    );
                    $playlists->setPath('/browse');
                }
            } else { // got sort - normal sort
                if ($user->subscription()->plan->isFree()) {
                    $playlists = $playlists->limit(7)->get();
                } else {
                    $playlists = $playlists->paginate(12);
                }
            }

            if ($user->subscription()->plan->isFree()) {
                $count = 0;
                $playlists->transform(function ($playlist, $index) {
                    global $count;
                    if ($count++ > 2) {
                        $playlist->name = Str::random(rand(15, 25));
                    }
                    return $playlist;
                });
            }
        }

        $playlists = $this->reOrderArtistsAndGenre($playlists, $q);


        $data['user'] = $user;
        $data['playlists'] = $playlists;
        $data['keywords'] = Tag::inRandomOrder()->limit(50)->get();
        $data['no_result_text'] = $q ? 'No result found' : 'Try clicking on any keyword or type anything in the search to see results';
        $data['search_limit_exceeded'] = !$user->subscription()->canUseFeature('search_limit');


        if ($user->subscription()->canUseFeature('search_limit') && $q) {
            $user->subscription()->recordFeatureUsage('search_limit');
        }

        return view('frontend.search', $data);
    }

    public function searchGuest() {
        $data = array();

        $q = \request('q', '');
        $q = filter_var($q, FILTER_SANITIZE_STRING);

        $this->addSearchToUser($q);

        $searchable_columns = ['name', 'genres', 'artists', 'all_artists'];

        $playlists = Playlist::whereAnyColumnLike($q, $searchable_columns);

        $data['results_count'] = $playlists->count();
        $data['currentUnlockedPlaylist'] = false;

        $playlists = $playlists->limit(4)->get();

        $playlists->transform(function ($playlist) {
            $playlist->name = Str::random(rand(15, 25));
            return $playlist;
        });

        $data['playlists'] = $playlists;
        $data['no_result_text'] = $q ? 'No result found' : 'Try clicking on any keyword or type anything in the search to see results';

        return view('frontend.search_guest', $data);
    }

    public function reportPlaylist(Request $request) {
        $request->validate([
            'playlist_id' => 'required',
            'message' => 'required',
        ]);

        ReportedPlaylist::create([
            'user_id' => auth()->id(),
            'playlist_id' => $request->playlist_id,
            'message' => $request->message
        ]);

        return redirect()->back()->with('success', 'Your feedback was submitted');
    }

    public function unlockPlaylist(Request $request) {


        try {
            if (user()->subscription()->getFeatureRemainings('credits') <= 0) {
                return redirect()->back()
                                ->with('warning', 'Not enough credits');
            }
        } catch (\Throwable $ex) {
            
        }


        $request->validate([
            'playlist_id' => 'required',
        ]);

        $playlist = Playlist::find($request->playlist_id);

        if ($playlist->isUnlocked()) {
            return redirect()->back()->with('warning', 'Playlist already unlocked.');
        }

        if (!USER()->subscription()->plan->isFree() && user()->alreadyUnlockedPlaylistFromThisCurator($playlist)) { // user already unlocked playlist from this curator
            $message = "You already unlocked this curator! No credits were deducted from your account :)";
            user()->unlockedPlaylists()->attach($request->playlist_id);
        } else { // New curator for this playlist
            $message = 'Playlist unlocked. You can view all your unlocked playlists in your profile';
            user()->unlockedPlaylists()->attach($request->playlist_id);
            user()->subscription()->recordFeatureUsage('credits');
        }
        return redirect()->back()
                        ->with('success', $message)
                        ->with('unlockedPlaylistId', $request->playlist_id)
                        ->with('currentUnlockedPlaylistId', $playlist->playlist_id);
    }

    private function replaceAccents($str) {

        $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");

        $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");

        return str_replace($search, $replace, $str);
    }

    private function reOrderArtistsAndGenre($playlists, $value) {
        foreach ($playlists as $k => $playlist) {

            // Put genre in first 5 elements
            $reorderedGenres = array_values($playlist->genres);
            foreach ($reorderedGenres as $key => $genre) {
                if (strpos(strtolower($this->replaceAccents($genre)), strtolower($this->replaceAccents($value))) !== false && $key > 5) {
                    try {
                        $rand = rand(0, 4);
                        $temp = $reorderedGenres[$rand];
                        $reorderedGenres[$rand] = $reorderedGenres[$key];
                        $reorderedGenres[$key] = $temp;
                    } catch (\Throwable $ex) {
                        continue;
                    }
                }
            }
            $playlist->genres = $reorderedGenres;
            // Put artist in first 5 elemtns if found
            $reorderedArtists = array_values($playlist->artists);
            foreach ($reorderedArtists as $key => $artist) {
                if (strpos(strtolower($this->replaceAccents($artist)), strtolower($this->replaceAccents($value))) !== false) {
                    if ($key > 5) {
                        try {
                            $rand = rand(0, 4);
                            $temp = $reorderedArtists[$rand];
                            $reorderedArtists[$rand] = $reorderedArtists[$key];
                            $reorderedArtists[$key] = $temp;
                        } catch (\Throwable $ex) {
                            var_dump($ex->getMessage());
                            continue;
                        }
                    } else { // artist in in first 5 - change to entities
//                        $reorderedArtists[$key] = $this->replaceAccents($reorderedArtists[$key]);
                    }
                }
            }
            $playlist->artists = $reorderedArtists;
        }

        return $playlists;
    }

    public function getSpotifyArtistsByName(Request $request, $name) {
        $spotifyController = new SpotifyController();
        $res = $spotifyController->doSpotifyRequest("search", ['q' => $name, 'type' => 'artist', 'limit' => 50, 'offset' => 0]);
        if (count($res['artists']['items']) > 0) {
            $artists = $res['artists']['items'];
            $artistsRes = [];
            foreach ($artists as $artist) {

                $image = isset($artist['images']) && count($artist['images']) > 0 ? $artist['images'][0]['url'] : "";
                if ($image === "") {
                    continue;
                }

                $artistsRes[] = [
                    'value' => $artist['id'],
                    'label' => $artist['name'],
                    'image' => $image,
                ];
            }
        }

        return response()->json($artistsRes);
    }

    private function addSearchToUser($keyword) {
        $user = Auth::user();
        if ($user) {
            $this->addSearchToDB($keyword, $user->id);
        } else {
            $this->addSearchToDB($keyword, 0);
        }

        return;
    }

    private function addSearchToDB($keyword, $userID) {
        try {
            $keyword = strtolower($keyword);

            $userData = UsersData::where('user_id', $userID)->first();
            if ($userData) {
                $searches = $userData->searches;

                if (isset($searches[$keyword])) {
                    $searches[$keyword][] = time();
                } else {
                    $searches[$keyword] = [time()];
                }
                $userData->searches = $searches;
                $userData->save();
            } else {
                $userData = new UsersData();

                $data = [
                    $keyword => [time()]
                ];
                $userData->user_id = $userID;
                $userData->searches = $data;
                $userData->save();
            }
        } catch (Exception $ex) {
            return;
        }
    }

    public function validateStripeCoupon(Request $request, $couponID) {

        $status = "failed";
        $message = "Coupon is invalid";

        $stripe = new \Stripe\StripeClient(Config('services.stripe.secret'));
        $promoCodes = $stripe->promotionCodes->all();

        $promoCodeID = $promoName = $promoType = $promoDiscount = false;

        foreach ($promoCodes['data'] as $promoCodeOBJ) {
            if ($promoCodeOBJ['code'] === $couponID && $promoCodeOBJ['coupon']['valid']) {
                $status = "success";
                $message = "Coupon is valid";
                $promoCodeID = $promoCodeOBJ['coupon']['id'];
                $promoName = $promoCodeOBJ['coupon']['name'];
                if ($promoCodeOBJ['coupon']['percent_off']) {
                    $promoType = "percent";
                    $promoDiscount = $promoCodeOBJ['coupon']['percent_off'];
                } else {
                    $promoType = "amount";
                    $promoDiscount = $promoCodeOBJ['coupon']['amount_off'] / 100;
                }

                break;
            }
        }

        return response()->json([
                    'status' => $status,
                    'message' => $message,
                    'promoCode' => $promoCodeID,
                    'promoName' => $promoName,
                    'promoType' => $promoType,
                    'promoDiscount' => $promoDiscount,
        ]);
    }

}
