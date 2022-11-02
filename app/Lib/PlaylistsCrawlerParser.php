<?php

namespace App\Lib;

use App\Models\Playlist;
use App\Models\SpotifyArtist;
use App\Models\SpotifyBlacklistUsers;
use App\Models\PlaylistCrawler;
use Spotify;
use App\Lib\BingController;
use DB;
use App\Lib\VerifyEmail;
use App\Models\Option;
use Log;
use App\Lib\SpotifyController;

class PlaylistsCrawlerParser {

    private $playlist;
    private $spotifyID;
    private $playlistData;
    private $spotifyAliasLimit;
    private $spotifyBlackListUsers;
    private $spotifyNewBlacklistUsers;
    private $spotifyUsers;
    private $bingRequests;
    private $spotifyRequests;
    private $totalUsersInserted;
    private $verifyEmail;
    private $spotifyApiLimitReached;
    private $spotifyController;
    private $spotifyArtists;

    public function __construct() {

        Option::where('option_key', '=', 'crawler_last_run')->pluck('option_value')->first();

        $this->getBlacklist();

        $this->spotifyNewBlacklistUsers = [];
        $this->spotifyUsers = [];
        $this->spotifyArtists = [];
        $this->bingRequests = 0;
        $this->spotifyRequests = 0;
        $this->totalUsersInserted = 0;
        $this->spotifyController = new SpotifyController();

        $this->verifyEmail = new VerifyEmail();
        $this->verifyEmail->setEmailFrom("from@email.com");
        $this->spotifyApiLimitReached = false;

        $this->initOptions();
//        Log::channel('playlist_crawler')->info('Playlist crawler cron is waking up!');
    }

    private function initOptions() {

        $lastTimeRun = Option::where('option_key', '=', 'crawler_last_run')->pluck('option_value')->first();

        $dateNow = new \DateTime();
        $date = new \DateTime($lastTimeRun);

        $interval = $date->diff($dateNow);

        $minutes = $interval->days * 24 * 60;
        $minutes += $interval->h * 60;
        $minutes += $interval->i;

        if ($minutes >= 60) { // past hour since last spotify calls
            $this->setSpotifyAliasLimit(600);
            $spotifyCallsLeft = Option::where('option_key', '=', 'crawler_spotify_calls_left')->first(); // init option with 600
            $spotifyCallsLeft->option_value = 600;
            $spotifyCallsLeft->save();

            $lastTimeRun = Option::where('option_key', '=', 'crawler_last_run')->first();
            $lastTimeRun->option_value = now();
            $lastTimeRun->save();
        } else {
            $spotifyCallsLeft = Option::where('option_key', '=', 'crawler_spotify_calls_left')->pluck('option_value')->first();
            $this->setSpotifyAliasLimit((int) $spotifyCallsLeft);

            if ($spotifyCallsLeft === 0) {
                Log::channel('playlist_crawler')->info('Playlist crawler - Spotify email calls is 600 - abort');
            }
        }
        return;
    }

    function getPlaylist() {
        return $this->playlist;
    }

    public function setPlaylist($playlist): void {
        try {
            if ($playlist->contacts && gettype($playlist->contacts) === "string") {
                $playlist->contacts = json_decode($playlist->contacts);
            }
        } catch (\Throwable $ex) {
            $playlist->contacts = null;
        }

        $this->playlist = $playlist;
        $this->spotifyID = $playlist->spotify_id;
    }

    function getSpotifyID() {
        return $this->spotifyID;
    }

    function setSpotifyID($spotifyID): void {
        $this->spotifyID = $spotifyID;
    }

    function getPlaylistData() {
        return $this->playlistData;
    }

    function setPlaylistData($playlistData): void {
        $this->playlistData = $playlistData;
    }

    public function clearData() {
        $this->setPlaylistData([]);
    }

    function getSpotifyAliasLimit() {
        return $this->spotifyAliasLimit;
    }

    function setSpotifyAliasLimit($spotifyAliasLimit): void {
        $this->spotifyAliasLimit = $spotifyAliasLimit;
    }

    function getSpotifyBlackListUsers() {
        return $this->spotifyBlackListUsers;
    }

    function setSpotifyBlackListUsers($spotifyBlackListUsers): void {
        $this->spotifyBlackListUsers = $spotifyBlackListUsers;
    }

    function getSpotifyNewBlacklistUsers() {
        return $this->spotifyNewBlacklistUsers;
    }

    function setSpotifyNewBlacklistUsers($spotifyNewBlacklistUsers): void {
        $this->spotifyNewBlacklistUsers = $spotifyNewBlacklistUsers;
    }

    function getSpotifyUsers() {
        return $this->spotifyUsers;
    }

    function setSpotifyUsers($spotifyUsers): void {
        $this->spotifyUsers = $spotifyUsers;
    }

    function getBingRequests() {
        return $this->bingRequests;
    }

    function getSpotifyRequests() {
        return $this->spotifyRequests;
    }

    function setBingRequests($bingRequests): void {
        $this->bingRequests = $bingRequests;
    }

    function setSpotifyRequests($spotifyRequests): void {
        $this->spotifyRequests = $spotifyRequests;
    }

    function getTotalUsersInserted() {
        return $this->totalUsersInserted;
    }

    function setTotalUsersInserted($totalUsersInserted): void {
        $this->totalUsersInserted = $totalUsersInserted;
    }

    function getVerifyEmail() {
        return $this->verifyEmail;
    }

    function setVerifyEmail($verifyEmail): void {
        $this->verifyEmail = $verifyEmail;
    }

    function getSpotifyApiLimitReached() {
        return $this->spotifyApiLimitReached;
    }

    function setSpotifyApiLimitReached($spotifyApiLimitReached): void {
        $this->spotifyApiLimitReached = $spotifyApiLimitReached;
    }

    function getSpotifyController() {
        return $this->spotifyController;
    }

    function setSpotifyController($spotifyController): void {
        $this->spotifyController = $spotifyController;
    }

    function getSpotifyArtists() {
        return $this->spotifyArtists;
    }

    function setSpotifyArtists($spotifyArtists): void {
        $this->spotifyArtists = $spotifyArtists;
    }

    private function getBlacklist() {
//        $users = SpotifyBlacklistUsers::all()
        $spotifyBlacklistUsers = SpotifyBlacklistUsers::orderBy('spotify_user_id', 'asc')->pluck('spotify_user_id')->toArray();
        $this->setSpotifyBlackListUsers($spotifyBlacklistUsers);
        return;
    }

    /*
     * Tests:
     * 1. is exist in db
     * 2. is exist in spotify
     * 3. followers > 100
     * 4. track > 0
     * 5. artists > 0
     * 6. updated in last 2 years
     * 
     * Scenario 1
     * 1. check if there is any email or alias on descption, example "example@gmail.com"
     * 2. If found, check for genres
     * 3. If genres, Insert to DB
     * 
     * Scenario 2
     * 1. No emails on description
     * 2. No alias on description
     * 3. Do couple of tests on the username:
     * 3.1 Username not smaller than 3 chars
     * 3.2 Username not greater than 18 chars
     * 3.3 Username contain only numbers
     * 3.4 Check that user is not on blacklist
     * 4. If passes username checks, add @gmail and check if email exists on Spotify
     * 5. Check that username is not popular
     * 6. check for genres
     * 7. add to db
     * 
     * 
     * 
     */

    public function parseCurrentPlaylist() {
        $error = "All good";
        $status = "success";
        $playlist = $this->getPlaylist();
        if ($this->isPlaylistExists()) { // validate test number 1
            $playlist->status = 'failed';
            $playlist->removal_slug = 'playlist-not-found';
            $playlist->removal_reason = 'Playlist not found on Spotify';
        } else {
            $spotifyDetails = $this->getSpotifyDataByPlaylistID(); // validate test number 2-6
            if ($spotifyDetails['status'] === 'failed') {
                $playlist->status = 'failed';
                $playlist->removal_slug = $spotifyDetails['failedSlug'];
                $playlist->removal_reason = $spotifyDetails['message'];


                $plData = $this->getPlaylistData();

                if (isset($plData['spotify_user'])) {
                    $playlist->spotify_user_id = $plData['spotify_user'];
                }
            } else {

                $plData = $this->getPlaylistData();
                $playlist->spotify_user_id = $plData['spotify_user'];


                $emails = $this->getEmailsFromDescription();
                $aliases = $this->getAliasesFromDescription();


                if ($emails || $aliases || $playlist->contacts) { // Scenario 1
                    $contacts = [];
                    if ($playlist->contacts) {
                        $contacts = $playlist->contacts;
                        if (gettype($playlist->contacts) === "string") {
                            $contacts = json_decode($playlist->contacts);
                        }
                    }
                    if ($emails) {
                        $contacts = array_merge($contacts, $emails);
                    }

                    if ($aliases) {
                        $contacts = array_merge($contacts, $aliases);
                    }

                    $contacts = array_unique($contacts);
                    $playlistData = $this->getPlaylistData();
                    $playlistData['contacts'] = $contacts;

                    $playlist->contacts = json_encode($contacts);
                    $this->setPlaylistData($playlistData);

                    $spotifyUserName = $playlistData['spotify_user'];
                    if ($this->isNameInBlacklist($spotifyUserName)) { // check if alias is in blacklist
                        $status = 'failed';
                        $message = 'Username is in the blacklist - ' . $spotifyUserName;
                        $slug = 'username-blacklist';
                    } else if ($this->getPlaylistGenres() && $this->getPlaylistMoodiness()) {

                        $playlist->status = 'success';
                        $playlist->removal_reason = 'Inserted to playlist DB';
                        $playlist->contacts = json_encode($this->getPlaylistData()['contacts']);
                        $this->addCurrentSpotifyUser();

                        $this->insertPlaylistToDB();
                    } else {
                        $playlist->status = 'failed';
                        $playlist->removal_slug = 'genres';
                        $playlist->removal_reason = 'There is no genres';
                    }
                } else { // Scenario 2
                    $usernameParse = $this->checkUserName();
                    if ($usernameParse['status'] === 'success') {
                        $playlistData = $this->getPlaylistData();
                        $playlist->contacts = json_encode($playlistData['contacts']);
                        if ($this->getPlaylistGenres() && $this->getPlaylistMoodiness()) {
                            $playlist->status = 'validate-email';
                            $playlist->removal_reason = 'Waiting for email validation';
                            $playlist->data = $this->getPlaylistData();
                            $this->addCurrentSpotifyUser();
                        } else {
                            $playlist->status = 'failed';
                            $playlist->removal_slug = 'genres';
                            $playlist->removal_reason = 'There is no genres';
                        }
                    } else {
                        $playlist->status = 'failed';
                        $playlist->removal_slug = $usernameParse['slug'];
                        $playlist->removal_reason = $usernameParse['reason'];
                    }
                }
            }
        }

        $playlist->save();


        if ($playlist->status === "success") {
            $this->setTotalUsersInserted($this->getTotalUsersInserted() + 1);
            Option::where('option_key', 'playlist_inserted_from_description')
                    ->update([
                        'option_value' => DB::raw('option_value+1')
            ]);
        }
        return true;
    }

    private function isPlaylistExists() {
        $playlist = Playlist::where('playlist_id', '=', $this->getSpotifyID())->get();
        return count($playlist) === 1;
    }

    private function addCurrentSpotifyUser() {
        $playlistData = $this->getPlaylistData();
        $spotifyUsers = $this->getSpotifyUsers();
        if (!in_array(strtolower($playlistData['spotify_user']), $spotifyUsers)) {
            $spotifyUsers[] = strtolower($playlistData['spotify_user']);
            $this->setSpotifyUsers($spotifyUsers);
        }
        return;
    }

    private function getSpotifyDataByPlaylistID() {
        $spotifyID = $this->getSpotifyID();

        $this->setSpotifyID($spotifyID);

        $status = "success";
        $message = "";
        $failedSlug = "";

        try {
            $spotifyController = $this->getSpotifyController();
            $res = $spotifyController->doSpotifyRequest("playlists/{$spotifyID}");

            if (!$res) {
                return array(
                    'status' => "failed",
                    'failedSlug' => 'playlist-not-found',
                    'message' => ""
                );
            }

            $playlistData = array(
                'playlist_id' => $spotifyID,
                'name' => $res['name'],
                'description' => $res['description'],
                'followers' => $res['followers']['total'],
                'tracks' => $res['tracks']['total'],
                'spotify_user' => $res['owner']['id'],
                'curator_name' => $res['owner']['display_name'],
                'last_update_date' => "",
            );

            if (isset($res['images'][0]['url'])) {
                $playlistData['image'] = $res['images'][0]['url'];
            }


            if ($playlistData['name'] === "") { // There is less than 100 followers
                $status = "failed";
                $failedSlug = 'playlist-name';
                $message = "Playlist name is empty";
            } else if (strpos(strtolower($res['name']), "soundtrack") !== false) { // There is soundtrack in the playlist name
                $status = "failed";
                $failedSlug = 'soundtrack';
                $message = "There is soundtrack word in playlist name";
            } else if ($playlistData['followers'] < 100) { // There is less than 100 followers
                $status = "failed";
                $failedSlug = 'followers';
                $message = "There is not enough followers: " . $playlistData['followers'];
            } else if ($playlistData['tracks'] === 0) { // there is no tracks on the playlist
                $status = "failed";
                $failedSlug = 'tracks';
                $message = 'There is 0 tracks';
            } else if ($playlistData['tracks'] > 400) { // there is no tracks on the playlist
                $status = "failed";
                $failedSlug = 'track-above';
                $message = "There is {$playlistData['tracks']} tracks";
            } else {
                $parsedData = $this->parseSpotifyPlaylist($res['tracks']);

                if (count($parsedData['artists']) < 3) { // no artists
                    $status = "failed";
                    $failedSlug = 'artists';
                    $message = "There is not enough artists: " . count($parsedData['artists']);
                } else if (round((time() - strtotime($parsedData['lastUpdateDate'])) / (60 * 60 * 24)) > 730) { // playlist wasn't update in the last 2 years
                    $status = "failed";
                    $failedSlug = 'last-updated';
                    $message = "The playlist updated long ago: " . explode("T", $parsedData['lastUpdateDate'], 2)[0];
                } else {
                    $playlistData = array_merge($playlistData, $parsedData);
                }
            }
            if ($status === "success") {
                $this->setPlaylistData($playlistData);
            }

            return array(
                'status' => $status,
                'failedSlug' => $failedSlug,
                'message' => $message
            );
        } catch (\Throwable $e) {
//            echo "<pre>";
            Log::channel('playlist_crawler')->info('Crawler exception', ['exception' => $e->getMessage()]);
//            var_dump($spotifyID);
//            echo $e->getMessage();
//            print_r($res);
//            echo __LINE__;
//            exit;


            $status = 'failed';
            $failedSlug = "";

            if ($e->getMessage() === "Invalid playlist Id") {
                $failedSlug = 'playlist-not-found';
                $message = 'Playlist not found on Spotify';
//                return "The playlist not exists on spotify";
            } else if ($e->getMessage() === "API rate limit exceeded") {
                Log::channel('playlist_crawler')->info('Spotify API rate limit exceeded');
                $this->setSpotifyApiLimitReached(true);
                $failedSlug = 'api-limit';
                $message = 'Spotify API rate limit exceeded';
            } else if ($e->getMessage() === "Not found.") {
                $failedSlug = 'playlist-wrong-id';
                $message = 'The playlist id is wrong';
            } else {
                $failedSlug = 'parser-exception';
                $message = $e->getMessage();
            }

            return array(
                'status' => $status,
                'failedSlug' => $failedSlug,
                'message' => $e->getMessage()
            );
        }
    }

    private function parseSpotifyPlaylist($tracks) {
        $mostUpdatedTrack = "1970-01-01T02:52:16Z";
        $totalTracks = 0;
        $i = 1;
        $artistsIDS = [];
        $topArtists = [];
        $tracksIDS = [];
        $spotifyController = $this->getSpotifyController();
        while (true) {
            foreach ($tracks['items'] as $key => $track) {
                try {
                    foreach ($track['track']['artists'] as $artist) {
                        $tracksIDS[] = $track['track']['id'];
                        if (!$artist['id']) {
                            continue;
                        }

                        if (!isset($topArtists[$artist['name']])) { // check if artists not exists
                            $artistsIDS[] = $artist['id'];
                            $topArtists[$artist['name']] = 1;
                        } else {
                            $topArtists[$artist['name']]++;
                        }
                    }
                } catch (\Throwable $ex) {
                    
                }

                $totalTracks++;
                if ($track['added_at'] > $mostUpdatedTrack) {
                    $mostUpdatedTrack = $track['added_at'];
                }
            }
            if ($tracks['next']) {
                try {
//                    $tracks = Spotify::playlistTracks($this->getSpotifyID())->offset($i++ * 100)->get();

                    $tracks = $spotifyController->doSpotifyRequest("playlists/{$this->getSpotifyID()}/tracks", ['offset' => $i++ * 100]);
                } catch (\Throwable $e) {
//                    echo 'Spotify error exception';
                    var_dump('hereeeeeeeeeeee');
                    var_dump($e->getMessage());

//                    Log::channel('playlist_crawler')->info('Spotify error exception - ' . $e->getMessage());
                    return false;
                }
            } else {
                break;
            }
        }


        arsort($topArtists);
        $allArtists = array_keys($topArtists);
        $topArtists = array_slice($topArtists, 0, count($topArtists) > 75 ? 75 : count($topArtists));
        $artists = array_keys($topArtists);

        return array(
            'lastUpdateDate' => $mostUpdatedTrack,
            'artists' => $artists,
            'topArtists' => $topArtists,
            'artistsIDS' => $artistsIDS,
            'allArtists' => $allArtists,
            'tracksIDS' => $tracksIDS
        );
    }

    private function getEmailsFromDescription() {
        $playlistData = $this->getPlaylistData();
        $emails = false;
        $res = [];
        preg_match_all("/[\w\.-]+@[\w\.-]+/", $playlistData['description'], $emails, PREG_SET_ORDER); // PREG_PATTERN_ORDER

        if ($emails) {
            $emails = $emails[0];
            foreach ($emails as $email) {
                if ($email !== " " && $email !== "") {
                    $res[] = trim($email);
                }
            }
        } else {

            return false;
        }
//        return $res;
        return $res && count($res) > 0 ? $res : false;
    }

    //(^|[" "])[@][\w\.-]+
    private function getAliasesFromDescription() {
        $playlistData = $this->getPlaylistData();
        $aliases = false;
        $res = [];
        preg_match_all('/(^|[" "])[@][\w\.-]+/', $playlistData['description'], $aliases, PREG_SET_ORDER); // PREG_PATTERN_ORDER

        if ($aliases) {
            $aliases = $aliases[0];
            foreach ($aliases as $alias) {
                if ($alias !== " " && $alias !== "") {
                    $aliasUsename = substr($alias, 1); // get the username without the @
                    if ($this->isInstagramUserExists($aliasUsename)) {
                        $res[] = trim($alias);
                    }
                }
            }
        } else {
            return false;
        }

        return $res && count($res) > 0 ? $res : false;
    }

    private function getPlaylistGenres() {
        $playlistData = $this->getPlaylistData();
        $artistsIDS = $playlistData['artistsIDS'];

        $jump = 50;
        $start = 0;
        $exit = false;
        $topGenres = [];

        $spotifyArtists = $this->getSpotifyArtists();

        while ($start < count($artistsIDS)) {

//            $response = Spotify::artists(array_slice($artistsIDS, $start, $jump))->get();
            $spotifyController = $this->getSpotifyController();
            $response = $spotifyController->doSpotifyRequest("artists", ['ids' => implode(',', array_slice($artistsIDS, $start, $jump))]);
//            $response = $spotifyController->doSpotifyRequest("artists", ['ids' => array_slice($artistsIDS, $start, $jump)]);


            foreach ($response['artists'] as $artist) {



                $spotifyArtists[$artist['id']] = $this->parseArtist($artist);
//                $parsedArtist = $this->parseArtist($artist);
//                print_r($parsedArtist);
//                exit;

                if (!isset($artist['genres'])) {
                    continue;
                }
                foreach ($artist['genres'] as $genre) {
                    if (!isset($topGenres[$genre])) { // check if artists not exists
                        $topGenres[$genre] = 1;
                    } else {
                        $topGenres[$genre]++;
                    }
                }
            }
            $start += $jump;
        }

        if (count($topGenres) === 0) {
            return false;
        }

        arsort($topGenres); // sort by values
        $topGenres = array_slice($topGenres, 0, count($topGenres) > 75 ? 75 : count($topGenres));
        $topGenres = array_flip($topGenres);
        $playlistData['genres'] = $topGenres;
        $this->setPlaylistData($playlistData);
        
        $this->setSpotifyArtists($spotifyArtists);

        return true;
    }

    private function parseArtist($artistOBJ) {
        return [
            'artist_id' => $artistOBJ['id'],
            'name' => $artistOBJ['name'],
            'image' => isset($artistOBJ['images'][0]['url']) ? $artistOBJ['images'][0]['url'] : null,
            'followers' => isset($artistOBJ['followers']['total']) ? $artistOBJ['followers']['total'] : 0,
            'genres' => isset($artistOBJ['genres']) ? json_encode($artistOBJ['genres']) : null,
            'popularity' => isset($artistOBJ['popularity']) ? $artistOBJ['popularity'] : 0,
        ];
    }

    private function getPlaylistMoodiness() {
        $playlistData = $this->getPlaylistData();
        $tracksIDS = $playlistData['tracksIDS'];

        $jump = 50;
        $start = 0;
        $exit = false;
        $moodiness = [];

        $moodinessCount = 0;
        $moodinessData = [
            "danceability" => 0,
            "energy" => 0,
            "speechiness" => 0,
            "acousticnesss" => 0,
            "instrumentalness" => 0,
            "liveness" => 0
        ];

        while ($start < count($tracksIDS)) {

//            $tracks = Spotify::audioFeaturesForTracks(implode(',', array_slice($tracksIDS, $start, $jump)))->get();

            $spotifyController = $this->getSpotifyController();
            $tracks = $spotifyController->doSpotifyRequest("audio-features", ['ids' => implode(',', array_slice($tracksIDS, $start, $jump))]);

            try {
                if (count($tracks['audio_features']) > 0) {
                    foreach ($tracks['audio_features'] as $track) {
                        if (!$track) {
                            continue;
                        }
                        $moodinessData["danceability"] += $track['danceability'];
                        $moodinessData["energy"] += $track['energy'];
                        $moodinessData["speechiness"] += $track['speechiness'];
                        $moodinessData["acousticnesss"] += $track['acousticness'];
                        $moodinessData["instrumentalness"] += $track['instrumentalness'];
                        $moodinessData["liveness"] += $track['liveness'];
                        $moodinessCount++;
                    }
                }
            } catch (\Throwable $ex) {
                continue;
            }


            $start += $jump;
        }

        if (count($moodinessData) === 0 || $moodinessCount === 0) {
            return false;
        }

        foreach ($moodinessData as $key => $value) {
            $moodinessData[$key] /= $moodinessCount;
        }


        $playlistData['moodiness'] = $moodinessData;
        $this->setPlaylistData($playlistData);
        return true;
    }

    public function isUserExistsInSpotify($name = false) {
        $this->setSpotifyRequests($this->getSpotifyRequests() + 1);
        $email = "{$name}@gmail.com";
        $url = "https://spclient.wg.spotify.com/signup/public/v1/account";
        $uri = "?validate=1&email={$email}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . $uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept-Language: en-US,en;q=0.9',
            'Connection: close',
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.66 Safari/537.36',
            'Accept: */*',
            'Origin: https://www.spotify.com',
            'Referer: https://www.spotify.com/',
            'Content-Type: application/json'
//            'Accept-Encoding: gzip, deflate'
        ));
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $json = json_decode($response, true);


        $this->setSpotifyAliasLimit($this->getSpotifyAliasLimit() - 1);

        if ($httpcode !== 200) {
            return false;
        }

        $isExists = array_key_exists('errors', $json) &&
                isset($json['errors']['email']) &&
                $json['errors']['email'] === "That email is already registered to an account.";

        return $isExists;
    }

    private function isNamePopular($name) {
        $this->setBingRequests($this->getBingRequests() + 1);
        $bingController = new BingController();
        $numberOfMatches = $bingController->getBingResultsCount($name);
        return $numberOfMatches > 5000;
    }

    /**
     * 
     * 
     * Scenario 2
     * 1. No emails on description
     * 2. No alias on description
     * 3. Do couple of tests on the username:
     * 3.1 Username not smaller than 3 chars
     * 3.2 Username not greater than 18 chars
     * 3.3 Username contain only numbers
     * 3.4 Check that user is not on blacklist
     * 4. If passes username checks, add @gmail and check if email exists on Spotify
     * 5. Check that username is not popular
     * 6. check for genres
     * 7. add to db
     * 
     * 
     */
    private function checkUserName() {
        $data = $this->getPlaylistData();
        $spotifyUserName = $data['spotify_user'];

        $status = 'success';
        $message = '';
        $slug = '';

        if (strlen($spotifyUserName) < 3) { // username < 3
            $status = 'failed';
            $message = 'Username is short - ' . strlen($spotifyUserName) . ' digits';
            $slug = 'username-short';
        } else if (strlen($spotifyUserName) > 24 && !ctype_alpha($spotifyUserName)) { // username > 24 and contain digits and letters
            $status = 'failed';
            $message = 'Username is long - ' . strlen($spotifyUserName) . ' digits - ' . $spotifyUserName;
            $slug = 'username-long';
        } else if (ctype_digit($spotifyUserName)) { // username contain only digits
            $status = 'failed';
            $message = 'Username contain only digits - ' . $spotifyUserName;
            $slug = 'username-digits';
        } else if ($this->isNameInBlacklist($spotifyUserName)) { // check if alias is in blacklist
            $status = 'failed';
            $message = 'Username is in the blacklist - ' . $spotifyUserName;
            $slug = 'username-blacklist';
        } else if (!$this->isUserExistsInSpotify($spotifyUserName)) { // username exists on spotify
            $status = 'failed';
            $message = 'Username is not exists on spotify - ' . $spotifyUserName . '@gmail.com';
            $slug = 'username-not-exists-spotify';
        } else if ($this->isNamePopular($spotifyUserName)) { // username is not popular
            if (!in_array(strtolower($spotifyUserName), $this->getSpotifyBlackListUsers())) {
                $blacklistUsers = $this->getSpotifyBlackListUsers();
                $blacklistUsers[] = strtolower($spotifyUserName);
                $this->setSpotifyBlackListUsers($blacklistUsers);
            }

            if (!in_array(strtolower($spotifyUserName), $this->getSpotifyNewBlacklistUsers())) {
                $blacklistNewUsers = $this->getSpotifyNewBlacklistUsers();
                $blacklistNewUsers[] = strtolower($spotifyUserName);
                $this->setSpotifyNewBlacklistUsers($blacklistNewUsers);
            }


            $status = 'failed';
            $message = 'Username is popular - ' . $spotifyUserName;
            $slug = 'username-popular';
        } else if (in_array(strtolower($spotifyUserName), $this->getSpotifyBlackListUsers())) {
            $status = 'failed';
            $message = 'Username in blacklist - ' . $spotifyUserName;
            $slug = 'username-blacklist';
        }


        if ($status === "success") { // Passed the spotify user check
            $data['contacts'] = ["{$data['spotify_user']}@gmail.com"];
            $this->setPlaylistData($data);
        }

        return array(
            'status' => $status,
            'reason' => $message,
            'slug' => $slug
        );
    }

    private function isNameInBlacklist($name) {
        return in_array($name, $this->getSpotifyBlackListUsers());
    }

    public function updateLists() {
//        echo "<pre>";
        // Update Spotify blacklist users
        $blacklistNewUsers = $this->getSpotifyNewBlacklistUsers();
//        $blacklistNewUsers = ['abcfff2324', 'moshe35t3t3'];
        var_dump("Total blacklist new users: " . count($blacklistNewUsers));
        $blacklistUsers = [];
        foreach ($blacklistNewUsers as $blacklistNewUser) {
            $blacklistUsers[] = ['spotify_user_id' => $blacklistNewUser];
        }
        $ccc = DB::table('spotify_blacklist_users')->insertOrIgnore($blacklistUsers);
        var_dump('Total inserted: ' . $ccc);

        
        //Update Spotify Artists
        $spotifyArtists = $this->getSpotifyArtists();
        var_dump("Total artists new users: " . count($spotifyArtists));
        $spotifyArtistsArray = [];
        foreach ($spotifyArtists as $spotifyID => $spotifyArtist) {
            $spotifyArtistsArray[] = $spotifyArtist;
        }
        
//        echo "<pre>";
//        print_r($spotifyArtistsArray);
        
        $spotifyArtistsInsert = SpotifyArtist::insert($spotifyArtistsArray);
//        $spotifyArtistsInsert = DB::table('spotify_artists')->insertOrIgnore($spotifyArtistsArray);
        var_dump('Total spotify artists inserted: ' . $spotifyArtistsInsert);
        
        //update Spotify users
        $spotifyUsers = $this->getSpotifyUsers();
        var_dump("Total new spotify users: " . count($spotifyUsers));
        $spotifyNewUsers = [];
        foreach ($spotifyUsers as $spotifyUser) {
            $spotifyNewUsers[] = ['spotify_user_id' => $spotifyUser];
        }

        Option::where('option_key', 'crawler_spotify_calls_left')
                ->update([
                    'option_value' => $this->getSpotifyAliasLimit()
        ]);

        Option::where('option_key', 'bing_requests')
                ->update([
                    'option_value' => DB::raw('option_value+' . $this->getBingRequests())
        ]);



        DB::table('spotify_users')->insertOrIgnore($spotifyNewUsers);
        var_dump('Crawler finished');
        var_dump('total bing requests: ' . $this->getBingRequests());
        var_dump('total spotify-email requests: ' . $this->getSpotifyRequests());

        Log::channel('playlist_crawler')->info('Playlist crawler finished');
        return;
    }

    private function isInstagramUserExists($username = false) {

//        var_dump('isInstagramUserExists');
//        $username = "ronaldo";
//        $url = "https://www.instagram.com/{$username}/";
//        $url = "https://www.instagram.com/ronaldoff554/?__a=1";
//        $url = "https://instausername.com/availability?q=ronaldo";
        $url = "https://instausername.com/availability?q={$username}";
//      var_dump($url);

        try {
            $content = file_get_contents($url);
            if (str_contains($content, "is free!")) {
                return false;
            } else {
                return true;
            }
        } catch (\Throwable $ex) { // user not found
            return false;
        }

        return true;
    }

    public function isEmailExists($email) {
        $verifyEmail = $this->getVerifyEmail();
        try {
            if ($verifyEmail->check($email)) {
//                var_dump('Email is valid');
                return true;
            } else {
//                var_dump('Email is not valid');
                return false;
            }
        } catch (\Throwable $ex) {
//            var_dump($ex->getMessage());
            return false;
        }

        return false;
    }

    public function isPlaylistExistsOnSpotify($playlistID) {
//        SpotifyAuth::setClientId('f6fffcf75db441e6a7a3212b276e0272');
//        SpotifyAuth::setClientSecret('73195a7e96cd4f97b03ec7d35ec31c2e');

        try {
//            $res = Spotify::playlist($playlistID)->get();
            $spotifyController = $this->getSpotifyController();
            $res = $spotifyController->doSpotifyRequest("playlists/{$playlistID}");
            if ($res['name']) {
                return true;
            }
        } catch (\Throwable $e) {

            if ($e->getMessage() === "Invalid playlist Id" || $e->getMessage() === "Not found.") {
                return false;
            } else if ($e->getMessage() === "API rate limit exceeded") {
//              //change api
            }
        }
        return false;
    }

    public function insertPlaylistToDB($playlistData = false) {
        if (!$playlistData) {
            $playlistData = $this->getPlaylistData();
        }

        $newPlaylist = new Playlist();
        $newPlaylist->playlist_id = $playlistData['playlist_id'];
        $newPlaylist->name = $playlistData['name'];
        $newPlaylist->description = $playlistData['description'];
        $newPlaylist->user_id = $playlistData['spotify_user'];
        $newPlaylist->number_of_tracks = $playlistData['tracks'];
        $newPlaylist->owner = $playlistData['curator_name'];
        $newPlaylist->contacts = $playlistData['contacts'];
        $newPlaylist->artists = $playlistData['artists'];
        $newPlaylist->followers = $playlistData['followers'];
        $newPlaylist->last_updated_on = $playlistData['lastUpdateDate'];
        $newPlaylist->top_artists = $playlistData['topArtists'];
        $newPlaylist->genres = $playlistData['genres'];
        $newPlaylist->all_artists = $playlistData['allArtists'];
        $newPlaylist->moodiness = $playlistData['moodiness'];

        if (isset($playlistData['image'])) {
            $newPlaylist->image = $playlistData['image'];
        }

        $newPlaylist->save();

        return;
    }

    public function extractPlaylistsAndWordsFromQuery($word) {
        echo "<pre>";
        $query = $word->query;
        Log::channel('spotify_playlists_updating')->info('Start parsing ' . $query);
        var_dump('Start parsing ' . $query);
//        $items = Spotify::searchItems($query, 'playlist')->limit(50)->offset(0)->get();

        $spotifyController = $this->getSpotifyController();
        $items = $spotifyController->doSpotifyRequest("search", ['q' => $query, 'type' => 'playlist', 'limit' => 50, 'offset' => 0]);

        $totalItems = $items['playlists']['total'];
        if ($totalItems === 0) {
            $word->status = "failed";
            $word->comments = 'There is 0 results for this query';
            $word->save();
            return;
        }

        $maxCounter = 20;
        if ($totalItems < 1000) {
            $maxCounter = (int) ceil($totalItems / 50);
        }

        $newSearchWords = [];
        $newPlaylistsIDS = [];
        for ($i = 0; $i < $maxCounter; $i++) { // maximum 1000 per query
            try {
//                $items = Spotify::searchItems($query, 'playlist')->limit(50)->offset($i * 50)->get();
                $items = $spotifyController->doSpotifyRequest("search", ['q' => $query, 'type' => 'playlist', 'limit' => 50, 'offset' => $i * 50]);

                $playlists = $items['playlists']['items'];
                $totalItems += count($playlists);

                foreach ($playlists as $playlist) {
                    $words = $this->getPotentialQueriesFromPlaylistName($playlist['name'], $query);
                    if (explode(' ', $query) > 0) {
                        if (!$words) {
                            $words = [];
                        }
                        $queryArray = explode(' ', $query);
                        $words1 = $this->getPotentialQueriesFromPlaylistName($playlist['name'], $queryArray[0]);
                        $words2 = $this->getPotentialQueriesFromPlaylistName($playlist['name'], $queryArray[1]);
                        if ($words1) {
                            $words = array_merge($words1, $words);
                        }
                        if ($words2) {
                            $words = array_merge($words2, $words);
                        }
                    }

                    if ($words) {
                        $newSearchWords = array_merge($newSearchWords, $words);
                    }
                    if ($playlist['tracks']['total'] > 0) {
                        $newPlaylistsIDS[] = $playlist['id'];
                    }
                }
            } catch (\Throwable $ex) {
                break;
            }
        }

//        var_dump($newSearchWords);
        $newSearchWords = array_unique($newSearchWords);
//        var_dump($newSearchWords);


        $newSearchWordsArray = [];
        foreach ($newSearchWords as $newSearchWord) {
            $newSearchWordsArray[] = ['query' => $newSearchWord];
        }


//        var_dump(count($newPlaylistsIDS));
        $newPlaylistsIDS = array_unique($newPlaylistsIDS);
//         var_dump(count($newPlaylistsIDS));
        $newPlaylistsIDSArray = [];
        foreach ($newPlaylistsIDS as $newPlaylistID) {
            $newPlaylistsIDSArray[] = ['spotify_id' => $newPlaylistID, 'status' => 'playlist-exists'];
        }


        var_dump('Starting insert');
        var_dump('Total words: ' . count($newSearchWords));

        $wordsInserted = DB::table('playlists_crawler_words')->insertOrIgnore($newSearchWordsArray);
        var_dump('Total words inserted: ' . $wordsInserted);
        Log::channel('spotify_playlists_updating')->info('Total words inserted: ' . $wordsInserted);

        var_dump('Total Playlists: ' . count($newPlaylistsIDS));

        $playlistsInserted = DB::table('playlists_crawler')->insertOrIgnore($newPlaylistsIDSArray);
        var_dump('Total Playlists inserted: ' . $playlistsInserted);
        Log::channel('spotify_playlists_updating')->info('Total Playlists inserted: ' . $playlistsInserted);

        if ($wordsInserted > 0 || $playlistsInserted > 0) {
            $word->status = "success";
            $word->total_new_words = $wordsInserted;
            $word->total_new_playlists = $playlistsInserted;

            Option::where('option_key', 'crawler_total_playlists_inserted')
                    ->update([
                        'option_value' => DB::raw('option_value+' . $playlistsInserted)
            ]);
            Option::where('option_key', 'crawler_total_words_inserted')
                    ->update([
                        'option_value' => DB::raw('option_value+' . $wordsInserted)
            ]);
        } else {

            $word->status = "failed";
            $word->comments = "All words and Playlists exists in the DB";
        }

        $word->save();
        return true;

        exit;
    }

    private function getPotentialQueriesFromPlaylistName($playlistName, $query) {
        $playlistName = preg_replace('/[^\p{L}\p{N}\s]/u', '', $playlistName);
        $playlistName = strtolower($playlistName);
        $playlistName = trim($playlistName);
        $playlistNameArray = explode(' ', $playlistName);


        $names = [];
        $foundWord = false;
        for ($i = 0; $i < count($playlistNameArray); $i++) {
            if ($playlistNameArray[$i] === $query) {
                if ($playlistNameArray[$i - 1] === "soundtrack" || $playlistNameArray[$i + 1] === "soundtrack") { // skip for soundtrack words
                    continue;
                }
                if ($i > 0 && $playlistNameArray[$i - 1] !== $query) {
                    $temp = trim($playlistNameArray[$i - 1] . " " . $playlistNameArray[$i]);
                    if ($temp !== $query) {
                        $names[] = $temp;
                    }
                }

                if ($i + 1 !== count($playlistNameArray) && $playlistNameArray[$i + 1] !== $query) {
                    $temp = trim($playlistNameArray[$i] . " " . $playlistNameArray[$i + 1]);
                    if ($temp !== $query) {
                        $names[] = $temp;
                    }
                }
            }
        }

        return count($names) > 0 ? $names : false;
    }

    public function getNewPlaylistsFromUser($spotifyUser) {
        $spotifyUserID = $spotifyUser->spotify_user_id;

        var_dump('Fetching ' . $spotifyUserID);
        $spotifyController = $this->getSpotifyController();


        $playlists = $spotifyController->doSpotifyRequest("users/{$spotifyUserID}/playlists", ['limit' => 50, 'offset' => 0]);

        if (!isset($playlists['total'])) {
            $spotifyUser->status = "failed";
            $spotifyUser->total_playlists = 0;
            $spotifyUser->save();
            return;
        }


        $totalPlaylists = $playlists['total'];
        if ($totalPlaylists < 2) {
            $spotifyUser->status = "failed";
            $spotifyUser->total_playlists = 0;
            $spotifyUser->save();
            return;
        }

        if ($spotifyUser->contacts) {
            $contacts = $spotifyUser->contacts;
        } else {
            $contacts = $this->getContactBySpotifyUserID($spotifyUserID);
        }


        $maxCounter = 20;
        if ($totalPlaylists < 1000) {
            $maxCounter = (int) ceil($totalPlaylists / 50);
        }
        $goodPlaylists = [];
        $goodPlaylistsIDS = [];
        for ($i = 0; $i < $maxCounter; $i++) { // maximum 1000 per query
            try {
                $playlists = $spotifyController->doSpotifyRequest("users/{$spotifyUserID}/playlists", ['limit' => 50, 'offset' => $i * 50]);

                if (!$playlists) {
                    break;
                }

                foreach ($playlists['items'] as $playlistItem) {

                    if (isset($playlistItem['tracks']['total']) && $playlistItem['tracks']['total'] === 0 ||
                            isset($playlistItem['tracks']['total']) && $playlistItem['tracks']['total'] > 400 ||
                            $playlistItem['owner']['id'] !== $spotifyUserID ||
                            $playlistItem['name'] === "" ||
                            strpos(strtolower($playlistItem['name']), "soundtrack") !== false
                    ) {
                        continue;
                    }
                    $playlistID = $playlistItem['id'];
                    $playlist = $spotifyController->doSpotifyRequest("playlists/{$playlistID}");
                    try {
                        if ($playlist['followers']['total'] < 100) {
                            continue;
                        } else {
                            $goodPlaylists[] = [
                                'spotify_id' => $playlistID,
                                'status' => 'playlist-exists',
                                'priority' => 10,
                                'contacts' => $contacts
                            ];
                            $goodPlaylistsIDS[] = $playlistID;
                        }
                    } catch (\Throwable $ex) {
                        Log::channel('crawler_spotify_users')->info('Exception', ['message' => $ex->getMessage()]);
                    }
                }
            } catch (\Throwable $ex) {
                break;
            }
        }

        $goodPlaylists = $this->checkIfPlaylistsExists($goodPlaylists, $goodPlaylistsIDS);


        if (count($goodPlaylists) === 0) {
            $spotifyUser->status = "failed";
            $spotifyUser->total_playlists = 0;
        } else {
            var_dump('Found ' . count($goodPlaylists) . ' Playlists');

            $totalPlaylistsInserted = DB::table('playlists_crawler')->insertOrIgnore($goodPlaylists);
            if ($totalPlaylistsInserted === 0) {
                $spotifyUser->status = "failed";
                $spotifyUser->total_playlists = 0;
            } else {
                var_dump('Inserted ' . $totalPlaylistsInserted . ' Playlists');
                $spotifyUser->status = "success";
                $spotifyUser->total_playlists = $totalPlaylistsInserted;
            }
        }

        $spotifyUser->save();

        return;
    }

    private function getContactBySpotifyUserID($spotifyUserID) {
        $contacts = null;
        $playlistCrawler = PlaylistCrawler::where('spotify_user_id', $spotifyUserID)
                ->whereNotNull('contacts')
                ->take(1)
                ->first();

        if ($playlistCrawler && $playlistCrawler->contacts !== "") {
            $contacts = $playlistCrawler->contacts;
        } else {
            $playlist = Playlist::where('user_id', $spotifyUserID)
                    ->whereNotNull('contacts')
                    ->take(1)
                    ->first();
            if ($playlist && $playlist->contacts !== "") {
                $contacts = $playlist->contacts;
            }
        }

        if (!$contacts) {
            return null;
        } else if (gettype($contacts) === "array") {
            return json_encode($contacts);
        } else {
            return $contacts;
        }

        return null;
    }

    private function checkIfPlaylistsExists($goodPlaylists, $goodPlaylistsIDS) {
        $existPlaylists = Playlist::whereIn('playlist_id', $goodPlaylistsIDS)->pluck('playlist_id')->toArray();
        foreach ($existPlaylists as $existPlaylist) {
            foreach ($goodPlaylists as $key => $goodPlaylist) {
                if ($existPlaylist === $goodPlaylist['spotify_id']) {
                    unset($goodPlaylists[$key]);
                }
            }
        }
        return $goodPlaylists;
    }

}
