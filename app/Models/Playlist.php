<?php

namespace App\Models;

use App\Traits\Searchable;
use Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model {

    use HasFactory,
        Searchable;

    public static function boot() {
        parent::boot();

        self::creating(function($model) {
            $columns = ['artists', 'top_artists', 'moodiness', 'genres', 'contacts',];
            foreach ($columns as $column) {
                if ($model->{$column} == null) {
                    $model->$column = array();
                }
            }
        });
    }

//    public $incrementing = false;

    protected $fillable = [
        'id', 'playlist_id', 'name', 'description','image', 'user_id', 'number_of_tracks', 'owner', 'contacts', 'artists',
        'followers', 'last_updated_on', 'top_artists', 'genres', 'moodiness', 'all_artists', 'data'
    ];
    protected $dates = [
        'last_updated_on',
    ];
    protected $casts = [
        'artists' => 'array',
        'top_artists' => 'array',
        'moodiness' => 'array',
        'genres' => 'array',
        'contacts' => 'array',
        'all_artists' => 'array',
        'data' => 'array',
    ];
    public static $moods = [
        'danceability' => [
            'color' => '#FF1493',
            'description' => 'Danceability describes how suitable a track is for dancing based on a combination of musical elements including tempo, rhythm stability, beat strength, and overall regularity. A value of 0 is least danceable and 100 is most danceable'
        ],
        'energy' => [
            'color' => '#9932CC',
            'description' => 'energy represents a perceptual measure of intensity and activity. Typically, energetic tracks feel fast, loud, and noisy'
        ],
        'speechiness' => [
            'color' => '#DC143C',
            'description' => 'Speechiness detects the presence of spoken words in a track. If the speechiness of a song is above 66, it is probably made of spoken words, a score between 33 and 66 is a song that may contain both music and words, and a score below 33 means the song does not have any speech'
        ],
        'acousticnesss' => [
            'color' => '#FFD700',
            'description' => 'This value describes how acoustic a track is. A score of 100 means the playlist is most likely to be an acoustic one.'
        ],
        'instrumentalness' => [
            'color' => '#FFA500',
            'description' => 'This value represents the amount of vocals in the song. The closer it is to 100, the more instrumental the song is.'
        ],
        'liveness' => [
            'color' => '#00CED1',
            'description' => 'This value describes the probability that the song was recorded with a live audience. According to the official documentation “a value above 80 provides strong likelihood that the track is live'
        ]
    ];

    public function moodValue($mood) {
        return round($mood * 100);
    }

    public function moodDescription($mood) {
        return self::$moods[$mood]['description'];
    }

    public function moodColor($mood) {
        return self::$moods[$mood]['color'];
    }

    public function getFormattedFollowersAttribute() {
        return kConverter($this->followers);
    }

    public function getSpotifyUrlAttribute() {
        return "open.spotify.com/playlist/$this->playlist_id";
    }

    public function getSpotifyDeepLinkAttribute() {
        return "spotify:playlist:$this->playlist_id";
    }

    public function getMoodinessAttribute($value) {
        return array_reverse(Arr::sort(json_decode($value)));
    }

    public function isUnlocked() {
        $user = auth()->user();

        return in_array($this->id, $user->unlockedPlaylists->pluck('id')->toArray());
    }

    public function shouldUnlock() {
        $user = auth()->user();

        $totalCredits = 0;

        try {
            $currentCredits = $user->subscription()->getFeatureValue('credits');
            $extraCredits = $user->subscription()->getExtraUsage('credits');
            $usageCredits = $user->subscription()->getFeatureUsage('credits');
            $totalCredits = $currentCredits + $extraCredits - $usageCredits;
        } catch (\Throwable $ex) {
            return false;
        }

        return $totalCredits > 0;
    }

    public function shouldDisplay() {
        $user = auth()->user();

        if (!$user->subscription()->plan->isFree()) {
            return true;
        }

        if ($this->isUnlocked()) {
            return true;
        }

        return $this->followers <= 300;
    }

    public function getContactEmailAttribute() {
        $emails = Arr::where($this->contacts, function ($value, $key) {
                    $regex = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/';
                    return preg_match($regex, $value);
                });
        return Arr::first($emails) ?? '';
    }

    public function calculatePlaylistScore($query) {

        $query = strtolower($query);

        $playlistNameAbsolutePoints = 10; // "edm"
        $playlistNameScorePoints = 5;  // "edm2021
        $playlistDescriptionAbsolutePoints = 4; // "edm"
        $playlistDescriptionPoints = 2; // "edmtomorrowland"
        $playlistArtistAbsolutePoints = 10; // 'tiesto'
        $playlistArtistPoints = 5; // 'tiestotrance'
        $playlistGenreAbsolutePoints = 2; // edm'
        $playlistGenrePoints = 1; // 'edm 2021'
        $playlistNameAndDescriptionAndGenreOrArtistPoints = 8; // got points in playlist_name, playlist_description and (genre or artist)
        $playlistNameAndDescriptionPoints = 5; // got points in playlist_name nad playlist_description
        $positiveWordsPoints = 2; // top, new, hits
        $currentYearPoints = 5; // 2021
        $lastYearPoints = 3; // 2020

        $positiveWords = ['top', 'new', 'hits'];
        $lastYear = date("Y", strtotime("-1 year"));
        $currentYear = date("Y");


        $playlistNameScore = $playlistNameAbsoluteScore = 0;

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            echo "<pre>";
            var_dump('*************************************');
            var_dump('Playlist id: ' . $this->playlist_id);
            var_dump('Playlist name: ' . $this->name);
        }



        foreach (explode(' ', strtolower($this->name)) as $word) {
            if ($word === $query) {
                $playlistNameAbsoluteScore++;
            } else if (strpos(strtolower($word), $query) !== false) {
                $playlistNameScore++;
            }
        }

//        $playlistNameScore = substr_count($this->name, $query);

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist name abs count: ' . $playlistNameAbsoluteScore);
            var_dump('Playlist name count: ' . $playlistNameScore);
        }


        $playlistdescriptionScore = $playlistdescriptionAbsoluteScore = 0;

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist description: ' . $this->description);
        }

        foreach (explode(' ', $this->description) as $word) {
            if (strtolower($word) === $query) {
                $playlistdescriptionAbsoluteScore++;
            } else if (strpos(strtolower($word), $query) !== false) {
                $playlistdescriptionScore++;
            }
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            //        $playlistdescriptionScore = substr_count($this->description, $query);
            var_dump('Playlist description abs count: ' . $playlistdescriptionAbsoluteScore);
            var_dump('Playlist description count: ' . $playlistdescriptionScore);
        }



        $artistsScore = $artistsAbsoluteScore = 0;
        foreach ($this->artists as $artist) {
            if ($artist === $query) {
                $artistsScore++;
            } else if (strpos(strtolower($artist), $query) !== false) {
                $artistsAbsoluteScore++;
            }
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist artists:');
            print_r($this->artists);
            var_dump('Playlist artists abs count: ' . $artistsAbsoluteScore);
            var_dump('Playlist artists count: ' . $artistsScore);
        }

        $genresScore = $genresAbsoluteScore = 0;
        foreach ($this->genres as $genre) {
            if ($genre === $query) {
                $genresAbsoluteScore++;
            } else if (strpos(strtolower($genre), $query) !== false) {
                $genresScore++;
            }
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist genres:');
            print_r($this->genres);
            var_dump('Playlist genres abs count: ' . $genresAbsoluteScore);
            var_dump('Playlist genres count: ' . $genresScore);
        }


        $positiveWordsScore = $currentYearScore = $lastYearScore = 0;


        foreach ($positiveWords as $positiveWord) {
            if (substr_count(strtolower($this->name), strtolower($positiveWord)) > 0) {
                $positiveWordsScore = 1;
                break;
            } else if (substr_count(strtolower($this->description), strtolower($positiveWord))) {
                $positiveWordsScore = 1;
                break;
            }
        }

        if (substr_count(strtolower($this->name), $currentYear) > 0) {
            $currentYearScore++;
        }
        if (substr_count($this->description, $currentYear) > 0) {
            $currentYearScore++;
        }

        if (substr_count($this->name, $lastYear) > 0) {
            $lastYearScore++;
        }
        if (substr_count($this->description, $lastYear) > 0) {
            $lastYearScore++;
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist current year words: ' . $currentYearScore);
            var_dump('Playlist current last year words: ' . $lastYearScore);
        }

//        $lastYearScore += substr_count($this->name, $lastYear);
//        $lastYearScore += substr_count($this->description, $lastYear);

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist positive words: ' . $positiveWordsScore);
            var_dump('Playlist last year words: ' . $lastYearScore);
        }

        foreach ($positiveWords as $positiveWord) {
            $positiveWordsScore += substr_count($this->description, $positiveWord);
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Playlist positive words: ' . $genresScore);
        }





        $totalScore = ($playlistNameScore * $playlistNameScorePoints) + ($playlistNameAbsoluteScore * $playlistNameAbsolutePoints);
        $totalScore += ($playlistdescriptionScore * $playlistDescriptionPoints) + ($playlistdescriptionAbsoluteScore * $playlistDescriptionAbsolutePoints);
        $totalScore += ($artistsScore * $playlistArtistPoints) + ($artistsAbsoluteScore * $playlistArtistAbsolutePoints);
        $totalScore += ($genresScore * $playlistGenrePoints) + ($genresAbsoluteScore * $playlistGenreAbsolutePoints);
        $totalScore += ($positiveWordsScore * $positiveWordsPoints);
        $totalScore += ($currentYearScore * $currentYearPoints);
        $totalScore += ($lastYearScore * $lastYearPoints);



        if (($playlistNameScore > 0 || $playlistNameAbsoluteScore > 0) && ($playlistdescriptionScore > 0 || $playlistdescriptionAbsoluteScore > 0) && ($artistsScore > 0 || $genresScore > 0)) {
            $totalScore += $playlistNameAndDescriptionAndGenreOrArtistPoints;
        } else if (($playlistNameScore > 0 || $playlistNameAbsoluteScore > 0) && ($playlistdescriptionScore > 0 || $playlistdescriptionAbsoluteScore > 0)) {
            $totalScore += $playlistNameAndDescriptionPoints;
        }

        if (isset($_GET['areldebug']) && $_GET['areldebug'] == "true") {
            var_dump('Total score: ' . $totalScore);
        }


        $this->playlist_score = $totalScore;
//        $this->score = $totalScore;
        return $this;
    }

}
