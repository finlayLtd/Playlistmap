<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\PlaylistCrawlerWord;
use App\Models\PlaylistCrawler;
use App\Models\Option;
use Illuminate\Http\Request;
use Spotify;
use App\Models\SpotifyBlacklistUsers;
use App\Models\SpotifyUsers;
use Log;
use App\Lib\PlaylistsCrawlerParser;
use App\Lib\SpotifyController;
use DB;
use Carbon\Carbon;
use App\Lib\BingController;

class PlaylistCrawlerController extends Controller {

    public function index() {
//        $q = request()->query('q');
        $playlistsCrawler = PlaylistCrawler::orderByDesc('id')->paginate(25);
        return view('backend.crawler.index', compact('playlistsCrawler'));
    }

    public function getPlaylistsStatisticsView() {

        $rows = Playlist::where('created_at', '>', date('2021-07-01'))
                ->selectRaw('year(created_at) year, month(created_at) month, count(*) data')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
                ->toArray();
        $xAxis = [];
        $yAxis = [];
        foreach ($rows as $row) {
            $xAxis[] = "{$row['month']} / {$row['year']}";
            $yAxis[] = $row['data'];
        }



        $playlistsByDay = Playlist::where('created_at', '>', Carbon::now()->subDays(60))
                ->selectRaw('year(created_at) year, month(created_at) month, day(created_at) day, count(*) data')
                ->groupBy('year', 'month', 'day')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->orderBy('day', 'asc')
                ->get()
                ->toArray();
        $xAxisDay = [];
        $yAxisDay = [];

        $totalPlaylists = 0;
        foreach ($playlistsByDay as $row) {
            $xAxisDay[] = "{$row['day']} / {$row['month']} / {$row['year']}";
            $yAxisDay[] = $row['data'];
            $totalPlaylists += $row['data'];
        }

        $totalPlaylists2Months = round($totalPlaylists / count($playlistsByDay));

        return view('backend.crawler.playlists-statistics', ['xAxis' => $xAxis, 'yAxis' => $yAxis, 'xAxisDay' => $xAxisDay, 'yAxisDay' => $yAxisDay, 'totalPlaylists2Months' => $totalPlaylists2Months]);
    }

    public function getWords() {
        $playlistsCrawlerWords = PlaylistCrawlerWord::orderByDesc('id')->paginate(25);
        return view('backend.crawler.words', compact('playlistsCrawlerWords'));
    }

    public function getSpotifyUsers() {
        $spotifyUsers = SpotifyUsers::orderByDesc('id')->paginate(25);
        return view('backend.crawler.spotify_users', compact('spotifyUsers'));
    }

    public function getSpotifyBlacklistUsers() {
        $spotifyBlacklistUsers = SpotifyBlacklistUsers::orderByDesc('id')->paginate(25);
        return view('backend.crawler.spotify_blacklist_users', compact('spotifyBlacklistUsers'));
    }

//
//    public function import(Request $request) {
//        $request->validate([
//            'csv' => 'required'
//        ]);
//
//        $last_inserted_playlist = Playlist::latest('id')->first();
//        $last_inserted_playlist_id = $last_inserted_playlist ? $last_inserted_playlist->id : 0;
//
//        $file = request()->file('csv');
//        Excel::import(new PlaylistsImport(), $file);
//
//        $number_of_imported_rows = Playlist::where('id', '>', $last_inserted_playlist_id)->count();
//        return redirect()->back()->with('success', $number_of_imported_rows . " Playlists Imported");
//    }


    public function updateCrawlerStatistics() {
        echo "<pre>";
        $starttime = microtime(true);

        $playlistsCrawler = DB::table('playlists_crawler')
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->orderBy('total', 'desc')
                ->get()
                ->toArray();


        $sum = 0;
        foreach ($playlistsCrawler as $playlistCrawler) {
            $sum += $playlistCrawler->total;
        }

        $success = $failed = 0;
        foreach ($playlistsCrawler as $playlistCrawler) {
            if ($playlistCrawler->status === "success") {
                $success = $playlistCrawler->total;
            } else if ($playlistCrawler->status === "failed") {
                $failed = $playlistCrawler->total;
            }

            $playlistCrawler->percent = number_format((($playlistCrawler->total / $sum) * 100), 2);
        }

        $validityRate = (($success / ($success + $failed)) * 100);


        $playlistsCrawler[] = (object) array('status' => 'Total', 'total' => $sum);

        $playlistsCrawlerSlugs = DB::table('playlists_crawler')
                ->select('removal_slug', DB::raw('count(*) as total'))
                ->where('removal_slug', '<>', '')
                ->groupBy('removal_slug')
                ->orderBy('total', 'desc')
                ->get()
                ->toArray();


        $playlistsByDates = $this->getPlaylistsStatistics();
        $total = 0;

        foreach ($playlistsCrawlerSlugs as $playlistCrawlerSlug) {
            $total += $playlistCrawlerSlug->total;
        }

        foreach ($playlistsCrawlerSlugs as $playlistCrawlerSlug) {
            $playlistCrawlerSlug->percent = number_format((($playlistCrawlerSlug->total / $total) * 100), 2);
        }

        $playlistsCrawlerSlugs[] = (object) array('removal_slug' => 'Total', 'total' => $total);


//        $spotifyUsers = array(
//            'Spotify Users' => count(DB::table('spotify_users')->get()),
//            'Spotify Blacklist Users' => count(DB::table('spotify_blacklist_users')->get())
//        );
        $spotifyUsers = array(
            'Spotify Users' => DB::table('spotify_users')->count(),
            'Spotify Blacklist Users' => DB::table('spotify_blacklist_users')->count()
        );

        $totalNewWords = PlaylistCrawlerWord::where('status', 'new')->get();

        $playlistCrawlerWordsStatistics = array(
            'New words to crawl' => $totalNewWords ? count($totalNewWords) : 0,
            //'Total words inserted' => count(PlaylistCrawlerWord::all()),
            'Total playlists inserted' => Option::where('option_key', 'crawler_total_playlists_inserted')->value('option_value')
        );

        $lastTimeModulesRun = $this->calculateModulesTimes();

        $spotifyUsersPlaylists = DB::table('playlists_crawler')
                ->where('priority', 10)
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->orderBy('total', 'desc')
                ->get()
                ->toArray();

        $successPlaylistsFromUsers = $failedPlaylistsFromUsers = $totalUserPlaylists = 0;
        foreach ($spotifyUsersPlaylists as $spotifyUsersPlaylist) {
            if ($spotifyUsersPlaylist->status === "success") {
                $successPlaylistsFromUsers = $spotifyUsersPlaylist->total;
            } else if ($spotifyUsersPlaylist->status === "failed") {
                $failedPlaylistsFromUsers = $spotifyUsersPlaylist->total;
            }
            $totalUserPlaylists += $spotifyUsersPlaylist->total;
        }

        $successPercent = $successPlaylistsFromUsers / ($successPlaylistsFromUsers + $failedPlaylistsFromUsers) * 100;

        $spotifyUsersPlaylists [] = (object) array('status' => 'Total', 'total' => $totalUserPlaylists);
        $spotifyUsersPlaylists [] = (object) array('status' => 'Success Rate', 'total' => $successPercent);


        //Inserted from
        $playlistInsertedDescription = intval(Option::where('option_key', 'playlist_inserted_from_description')->value('option_value'));
        $playlistInsertedAliasGmail = Option::where('option_key', 'playlist_inserted_from_alias')->value('option_value');

        $playlistInsertedDescription -= $successPlaylistsFromUsers;

        $playlistsSource = array(
            [
                'label' => 'Playlist From Users Module',
                'value' => $successPlaylistsFromUsers,
                'percent' => $successPlaylistsFromUsers / ($playlistInsertedDescription + $playlistInsertedAliasGmail + $successPlaylistsFromUsers) * 100
            ],
            [
                'label' => 'Playlist Description',
                'value' => $playlistInsertedDescription,
                'percent' => $playlistInsertedDescription / ($playlistInsertedDescription + $playlistInsertedAliasGmail + $successPlaylistsFromUsers) * 100
            ],
            [
                'label' => 'Playlist Alias Gmail',
                'value' => $playlistInsertedAliasGmail,
                'percent' => $playlistInsertedAliasGmail / ($playlistInsertedDescription + $playlistInsertedAliasGmail + $successPlaylistsFromUsers) * 100
            ]
        );

        // Crawler users module

        $crawlerSpotifyUsersWithPlaylists = Option::where('option_key', 'crawler_users_total_found_with_playlists')->value('option_value');
        $crawlerSpotifyUsersWithoutPlaylists = Option::where('option_key', 'crawler_users_total_found_without_playlists')->value('option_value');
        $crawlerSpotifyUsersNotFound = Option::where('option_key', 'crawler_users_total_not_found')->value('option_value');

        $totalUsersCovered = ($crawlerSpotifyUsersWithPlaylists + $crawlerSpotifyUsersWithoutPlaylists + $crawlerSpotifyUsersNotFound);

        $totalPlaylistsInserted = SpotifyUsers::where([
                    ['status', 'success'],
                    ['source', 'crawler_users_module']
                ])
                ->sum('total_playlists');

        $crawlerUsersModule = array(
            [
                'label' => 'Users with playlists',
                'value' => $crawlerSpotifyUsersWithPlaylists,
                'percent' => ($crawlerSpotifyUsersWithPlaylists / $totalUsersCovered) * 100
            ],
            [
                'label' => 'Users without playlists',
                'value' => $crawlerSpotifyUsersWithoutPlaylists,
                'percent' => ($crawlerSpotifyUsersWithoutPlaylists / $totalUsersCovered) * 100
            ],
            [
                'label' => 'Users not found',
                'value' => $crawlerSpotifyUsersNotFound,
                'percent' => ($crawlerSpotifyUsersNotFound / $totalUsersCovered) * 100
            ],
            [
                'label' => 'Total users covered',
                'value' => $totalUsersCovered,
                'bold' => true
            ],
            [
                'label' => 'Total playlists inserted',
                'value' => $totalPlaylistsInserted,
                'bold' => true
            ],
        );

        $data = [
            'playlistsCrawler' => $playlistsCrawler,
            'playlistsCrawlerSlugs' => $playlistsCrawlerSlugs,
            'playlistsCrawlerStatistics' => $playlistsByDates,
            'spotifyUsers' => $spotifyUsers,
            'playlistCrawlerWordsStatistics' => $playlistCrawlerWordsStatistics,
            'validityRate' => $validityRate,
            'lastTimeModulesRun' => $lastTimeModulesRun,
            'playlistsSource' => $playlistsSource,
            'spotifyUsersPlaylists' => $spotifyUsersPlaylists,
            'crawlerUsersModule' => $crawlerUsersModule
        ];

        Option::where('option_key', 'crawler_statistics')
                ->update([
                    'option_value' => json_encode($data)
        ]);
        var_dump('Statistics updated');

        $lastTimeRun = Option::where('option_key', '=', 'crawler_statistics_last_update')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();

        return;


        return view('backend.crawler.dashboard', [
            'playlistsCrawler' => $playlistsCrawler,
            'playlistsCrawlerSlugs' => $playlistsCrawlerSlugs,
            'playlistsCrawlerStatistics' => $playlistsByDates,
            'spotifyUsers' => $spotifyUsers,
            'playlistCrawlerWordsStatistics' => $playlistCrawlerWordsStatistics,
            'validityRate' => $validityRate,
            'lastTimeModulesRun' => $lastTimeModulesRun,
            'playlistsSource' => $playlistsSource,
            'spotifyUsersPlaylists' => $spotifyUsersPlaylists
        ]);
    }

    public function show() {
        $data = json_decode(Option::where('option_key', '=', 'crawler_statistics')->pluck('option_value')->first(), true);
        $data['lastTimeModulesRun'] = $this->calculateModulesTimes();


        $statisticsDateTime = Option::where('option_key', '=', 'crawler_statistics_last_update')->pluck('option_value')->first();
        $data['statisticsTime'] = Carbon::parse($statisticsDateTime)->diffForHumans();


        return view('backend.crawler.dashboard', $data);
    }

    private function calculateModulesTimes() {
        $lastTimeRunEmails = Option::where('option_key', '=', 'crawler_emails_last_run')->pluck('option_value')->first();
        $lastTimeRunMain = Option::where('option_key', '=', 'crawler_main_last_run')->pluck('option_value')->first();
        $lastTimeRunWords = Option::where('option_key', '=', 'crawler_words_last_run')->pluck('option_value')->first();
        $lastTimeRunUsers = Option::where('option_key', '=', 'crawler_users_last_run')->pluck('option_value')->first();
        $lastTimeRunCrawlerUsers = Option::where('option_key', '=', 'crawler_users_module_last_run')->pluck('option_value')->first();
        return array(
            'main' => $this->getValueAndColorFromDate($lastTimeRunMain, 'Playlists Parser'),
            'words' => $this->getValueAndColorFromDate($lastTimeRunWords, 'Words module'),
            'emails' => $this->getValueAndColorFromDate($lastTimeRunEmails, 'Validate Emails'),
            'users' => $this->getValueAndColorFromDate($lastTimeRunUsers, 'Users Playlists'),
            'crawler_users' => $this->getValueAndColorFromDate($lastTimeRunCrawlerUsers, 'Crawler Spotify Users'),
        );
    }

    private function getValueAndColorFromDate($date, $moduleName) {
        $color = "success";

        $carbonNow = Carbon::now();
        $diff = $carbonNow->diffInMinutes($date);

        if ($diff > 60) {
            $color = "danger";
        } else if ($diff < 60 && $diff > 30) {
            $color = "warning";
        }

        return [
            'value' => Carbon::parse($date)->diffForHumans(),
            'color' => $color,
            'label' => $moduleName
        ];
    }

    private function getPlaylistsStatistics() {
        $playlistsCrawler = PlaylistCrawler::select('id', 'status', 'updated_at')->where('status', 'success')->get();
        $results = array();
        $results['Today'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->format('Y-m-d') . " 00:00:00", Carbon::now()->format('Y-m-d') . " 23:59:59");
        $results['Yesterday'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::yesterday()->format('Y-m-d') . " 00:00:00", Carbon::yesterday()->format('Y-m-d') . " 23:59:59");
        $results['Last Week'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->subDays(7)->format('Y-m-d') . " 00:00:00", Carbon::now()->format('Y-m-d') . " 23:59:59");
        $results['This Month'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->firstOfMonth()->format('Y-m-d') . " 00:00:00", Carbon::now()->lastOfMonth()->format('Y-m-d') . " 23:59:59");
//        $results['Last Month'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->startOfMonth()->subMonthsNoOverflow()->format('Y-m-d') . " 00:00:00", Carbon::now()->subMonthsNoOverflow()->endOfMonth()->format('Y-m-d') . " 23:59:59");
        $results['This Year'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->startOfYear()->format('Y-m-d') . " 00:00:00", Carbon::now()->endOfYear()->format('Y-m-d') . " 23:59:59");
//        $results['Last Year'] = $this->getRowsCountByDate($playlistsCrawler, Carbon::now()->subYear()->startOfYear()->format('Y-m-d') . " 00:00:00", Carbon::now()->subYear()->endOfYear()->format('Y-m-d') . " 23:59:59");
        $results['Total'] = count($playlistsCrawler);
        return $results;
    }

    /** This function return roi result count by date, separated for internal and external users
     * 
     * @param date $from
     * @param date $to
     * @return array
     */
    private function getRowsCountByDate($rows, $from, $to) {
        return $rows->whereBetween('updated_at', [$from, $to])->count();
//        return count($rows->whereBetween('updated_at', [$from, $to]));
    }

    public function runPlaylistsCrawler() {
        Log::channel('playlist_crawler')->info('Playlist crawler cron is waking up!');
        $starttime = microtime(true);
        $playlistsCrawlerMaxValue = PlaylistCrawler::where('status', 'playlist-exists')->max('priority');
        if ($playlistsCrawlerMaxValue > 0) {
            $playlistsCrawler = PlaylistCrawler::where([['status', '=', 'playlist-exists'], ['priority', '=', $playlistsCrawlerMaxValue]])->take(500)->get();
//            $playlistsCrawler = PlaylistCrawler::where([['status', '=', 'playlist-exists'], ['priority', '=', $playlistsCrawlerMaxValue]])->take(25)->get();
            if (count($playlistsCrawler) < 50) {
                $playlistsCrawler = PlaylistCrawler::where('status', 'playlist-exists')->orderBy('id', 'asc')->take(500)->get();
            }
        } else {
            $playlistsCrawler = PlaylistCrawler::where('status', 'playlist-exists')->orderBy('id', 'asc')->take(500)->get();
        }

        $playlistCrawlerController = new PlaylistsCrawlerParser();
        $totalPlaylistsCover = 0;
        foreach ($playlistsCrawler as $playlistCrawler) {
            if ($playlistCrawlerController->getSpotifyAliasLimit() === 0) { // spotify limit of 600 has been reached
                Log::channel('spotify_playlists_updating')->info('Playlist crawler - Spotify email calls is over');
                break;
            } else if ($playlistCrawlerController->getSpotifyApiLimitReached()) {
                Log::channel('spotify_playlists_updating')->info('Playlist crawler - Spotify API limit reached - aborting...');
                break;
            }
            if ((microtime(true) - $starttime) > 82) { // 82
                break;
            }

            $totalPlaylistsCover++;


            $playlistCrawlerController->clearData();
            $playlistCrawlerController->setPlaylist($playlistCrawler);


            $playlistCrawlerController->parseCurrentPlaylist();
        }


        $playlistCrawlerController->updateLists();


        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        Log::channel('playlist_crawler')->info('Total playlists covered: ' . $totalPlaylistsCover);
        Log::channel('playlist_crawler')->info('Playlist crawler cron total time: ' . $timediff . ' seconds');
        Log::channel('playlist_crawler')->info('Playlist crawler cron is finished');
        var_dump("Total time difference: " . $timediff . " seconds");

        $lastTimeRun = Option::where('option_key', '=', 'crawler_main_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();

        exit;
    }

    public function getNewPlaylistsToCrawler() {
        Log::channel('spotify_playlists_updating')->info('Getting new playlists crawler is waking up!');
        $starttime = microtime(true);

        $wordMaxPriorityValue = PlaylistCrawlerWord::where('status', 'new')->max('priority');
        if ($wordMaxPriorityValue) {
            $words = PlaylistCrawlerWord::where([['status', '=', 'new'], ['priority', '=', $wordMaxPriorityValue]])->inRandomOrder()->take(250)->get();
        } else {
            $words = PlaylistCrawlerWord::where('status', 'new')->inRandomOrder()->take(250)->get();
        }

        if (!$words) {
            Log::channel('spotify_playlists_updating')->info('Cannot find a word to parse, aborting.');
            return;
        }

        $playlistCrawlerController = new PlaylistsCrawlerParser();
        $totalPlaylistsCover = 0;

        foreach ($words as $word) {
            if ((microtime(true) - $starttime) > 80) {
                break;
            }
            $playlistCrawlerController->extractPlaylistsAndWordsFromQuery($word);
            $totalPlaylistsCover++;
        }

        var_dump('Total playlists cover: ' . $totalPlaylistsCover);

        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        Log::channel('spotify_playlists_updating')->info('Total playlists cover: ' . $totalPlaylistsCover);
        Log::channel('spotify_playlists_updating')->info('New playlists crawler total time: ' . $timediff . ' seconds');
        Log::channel('spotify_playlists_updating')->info('Getting new playlists Finished');

        $lastTimeRun = Option::where('option_key', '=', 'crawler_words_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();
        exit;
    }

    public function getNewPlaylistsToCrawler1() {
        Log::channel('spotify_playlists_updating')->info('Getting new playlists crawler is waking up!');
        $starttime = microtime(true);

        $wordMaxPriorityValue = PlaylistCrawlerWord::where('status', 'new')->max('priority');
        if ($wordMaxPriorityValue) {
            $word = PlaylistCrawlerWord::where([['status', '=', 'new'], ['priority', '=', $wordMaxPriorityValue]])->inRandomOrder()->take(1)->first();
        } else {
            $word = PlaylistCrawlerWord::where('status', 'new')->inRandomOrder()->take(1)->first();
        }

        if (!$word) {
            Log::channel('spotify_playlists_updating')->info('Cannot find a word to parse, aborting.');
            return;
        }

        $playlistCrawlerController = new PlaylistsCrawlerParser();
//        $query = $word->query;
        $res = $playlistCrawlerController->extractPlaylistsAndWordsFromQuery($word);
        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        Log::channel('spotify_playlists_updating')->info('New playlists crawler total time: ' . $timediff . ' seconds');
        Log::channel('spotify_playlists_updating')->info('Getting new playlists Finished');
//        var_dump($res);

        $lastTimeRun = Option::where('option_key', '=', 'crawler_words_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();
        exit;
    }

    public function updatePlaylistFromSpotify() {
        Log::channel('spotify_playlists_updating')->info('Update playlists cron waking up!');
        $playlists = Playlist::orderBy('id', 'asc')->take(100)->get();
        $updatedPlaylist = 0;
        $spotifyController = new SpotifyController();


        foreach ($playlists as $key => $playlist) {
            try {
//                $res = Spotify::playlist($playlist->playlist_id)->get();
                $res = $spotifyController->doSpotifyRequest("playlists/{$playlist->playlist_id}");
            } catch (\Throwable $e) {
                Log::channel('spotify_playlists_updating')->info('Spotify error exception - ' . $e->getMessage(), ['playlistID' => $playlist->playlist_id]);
                if ($e->getMessage() === "API rate limit exceeded") {
                    Log::channel('spotify_playlists_updating')->info("Total playlists updated: {$updatedPlaylist}");
                    Log::channel('spotify_playlists_updating')->info('Spotify rate limit exceeded - exit cron', ['playlistID' => $playlist->playlist_id]);
                    return;
                }
                continue;
            }

            $tracks = $res['tracks'];
            $followers = $res['followers']['total'];
            $tracksTotal = $res['tracks']['total'];
            $name = $res['name'];

            $result = $this->getMostUpdatedTrackDateAndArtists($tracks, $playlist->playlist_id);
            if (!$result['date']) {
                continue;
            }

            $dateOnly = explode('T', $result['date'])[0];
            $isUpdated = $playlist->update([
                'name' => $name,
                'number_of_tracks' => $tracksTotal,
                'followers' => $followers,
                'last_updated_on' => $dateOnly,
                'all_artists' => isset($result['artists']) ? $result['artists'] : []
            ]);
            if ($isUpdated) {
                $playlist->touch();
                $updatedPlaylist++;
            }
        }
        Log::channel('spotify_playlists_updating')->info("Total playlists updated: {$updatedPlaylist}");
        var_dump("Total playlists updated: {$updatedPlaylist}");
        exit;
    }

    public function runSpotifyPlaylistCrawlerCheck(Request $request) {

        $spotifyPlaylists = PlaylistCrawler::where('status', 'new')->orderBy('id', 'asc')->take(100)->get();
        echo "<pre>";

        $playlistCrawlerController = new PlaylistsCrawlerParser();


        $exists = 0;
        $notExists = 0;
        foreach ($spotifyPlaylists as $spotifyPlaylist) {
            if ($playlistCrawlerController->isPlaylistExistsOnSpotify($spotifyPlaylist->spotify_id)) {
                $exists++;
                $spotifyPlaylist->status = 'playlist-exists';
            } else {
                $notExists++;
                $spotifyPlaylist->status = 'failed';
                $spotifyPlaylist->removal_slug = 'playlist-not-found';
                $spotifyPlaylist->removal_reason = 'Playlist not found on Spotify';
            }

            $spotifyPlaylist->save();
        }

        var_dump('Exists: ' . $exists);
        var_dump('Not exists: ' . $notExists);
//        echo 'done';
        exit;
    }

    public function runSpotifyPlaylistCrawlerEmailCheck() {
        Log::channel('crawler_validating_email')->info("Crawler emails check waking up");
        $starttime = microtime(true);
        $playlistCrawlerController = new PlaylistsCrawlerParser();
        $spotifyPlaylists = PlaylistCrawler::where('status', 'validate-email')->orderBy('id', 'asc')->take(7)->get();
        echo "<pre>";
        $validated = false;
        $totalEmailsValidated = 0;
        foreach ($spotifyPlaylists as $spotifyPlaylist) {
//            var_dump('*****************************');
//            var_dump($spotifyPlaylist->id);

            $playlistData = $spotifyPlaylist['data'];
            $email = $playlistData['contacts'][0];


            if ($playlistCrawlerController->isEmailExists($email)) {
                $totalEmailsValidated++;
                $playlistCrawlerController->insertPlaylistToDB($playlistData);

                $spotifyPlaylist->status = 'success';
                $spotifyPlaylist->removal_slug = '';
                $spotifyPlaylist->removal_reason = 'Inserted to playlist DB';
            } else { // email is fake
                $spotifyPlaylist->status = 'failed';
                $spotifyPlaylist->removal_slug = 'email-not-exists';
                $spotifyPlaylist->removal_reason = 'Email is fake - ' . $email;
            }
            $spotifyPlaylist->save();
        }

        Option::where('option_key', 'playlist_inserted_from_alias')
                ->update([
                    'option_value' => DB::raw('option_value+' . $totalEmailsValidated)
        ]);

        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        Log::channel('crawler_validating_email')->info('Crawler emails check total time: ' . $timediff . ' seconds');
        Log::channel('crawler_validating_email')->info("Crawler emails check finished");

        $lastTimeRun = Option::where('option_key', '=', 'crawler_emails_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();
        exit;
    }

    private function getMostUpdatedTrackDateAndArtists($tracks, $playlist_id) {
        $mostUpdatedTrack = "1970-01-01T02:52:16Z";
        $totalTracks = 0;
        $i = 1;
        $artists = [];
        $spotifyController = new SpotifyController();
        while (true) {
            foreach ($tracks['items'] as $key => $track) {
                try {
                    foreach ($track['track']['artists'] as $artist) {
                        if (!in_array($artist['name'], $artists)) { // check if artists not exists
                            $artists[] = $artist['name']; // add to artists new artists
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
                    $tracks = $spotifyController->doSpotifyRequest("playlists/{$this->getSpotifyID()}/tracks", ['offset' => $i++ * 100]);
                } catch (\Throwable $e) {
                    Log::channel('spotify_playlists_updating')->info('Spotify error exception - ' . $e->getMessage());
                    return false;
                }
            } else {
                break;
            }
        }
        sort($artists);
        return array(
            'date' => $mostUpdatedTrack,
            'artists' => $artists
        );
    }

    public function getNewPlaylistsFromUsers(Request $request) {
        echo "<pre>";

        $starttime = microtime(true);
        Log::channel('crawler_spotify_users')->info('Get new playlists from users cron started');

//        $spotifyUser = SpotifyUsers::where('status', '=', 'new')->orderBy('id', 'DESC')->limit(1)->first();

        $spotifyUsers = SpotifyUsers::where('status', '=', 'new')->limit(500)->get();

        if (!$spotifyUsers) {
            Log::channel('crawler_spotify_users')->info("No users to parse - aborting");
            return;
        }

        $totalUsersCovered = 0;
        $playlistCrawlerController = new PlaylistsCrawlerParser();
        foreach ($spotifyUsers as $spotifyUser) {

            if ((microtime(true) - $starttime) > 75) {
                break;
            }

            if ($this->usernameConatainBlacklistWord($spotifyUser->spotify_user_id) ||
                    !ctype_digit($spotifyUser->spotify_user_id) && $this->usernameInBlacklist($spotifyUser->spotify_user_id)
            ) {
                var_dump('username in blacklist');
                $spotifyUser->status = "failed";
                $spotifyUser->total_playlists = 0;
                $spotifyUser->save();
                continue;
            }


            $playlistCrawlerController->getNewPlaylistsFromUser($spotifyUser);
            $totalUsersCovered++;
        }



//        if ($spotifyUser) {
//            Log::channel('crawler_spotify_users')->info('Get new playlists from id - ' . $spotifyUser->spotify_user_id);
//        }



        /*
          $spotifyUser = SpotifyUsers::where('status', '=', 'new')->limit(1)->first();
          if (!$spotifyUser) {
          Log::channel('crawler_spotify_users')->info("No users to parse - aborting");
          return;
          }


          if ($this->usernameInBlacklist($spotifyUser->spotify_user_id) || $this->usernameConatainBlacklistWord($spotifyUser->spotify_user_id)) {
          var_dump('username in blacklist');
          $spotifyUser->status = "failed";
          $spotifyUser->total_playlists = 0;
          $spotifyUser->save();
          return;
          }

          if ($spotifyUser) {
          Log::channel('crawler_spotify_users')->info('Get new playlists from id - ' . $spotifyUser->spotify_user_id);
          $playlistCrawlerController = new PlaylistsCrawlerParser();
          $playlistCrawlerController->getNewPlaylistsFromUser($spotifyUser);
          }


         */


        var_dump("Total users covered: {$totalUsersCovered}");

        $endtime = microtime(true);
        $timediff = $endtime - $starttime;
        Log::channel("Total users covered: {$totalUsersCovered}");
        Log::channel('crawler_spotify_users')->info('Get new playlists from users total time: ' . $timediff . ' seconds');
        Log::channel('crawler_spotify_users')->info("Get new playlists from users finished");

        $lastTimeRun = Option::where('option_key', '=', 'crawler_users_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();

        exit;
    }

    private function usernameInBlacklist($username) {
        $user = SpotifyBlacklistUsers::where('spotify_user_id', $username)->get()->first();
        return !!$user;
    }

    private function spotifyNameContainMainUsers($userID) {
        $basicUsers = ['digster', 'topsify', 'spotify', 'filtr', 'sonymusic'];
        foreach ($basicUsers as $basicUser) {
            if (str_contains($userID, $basicUser)) {
                return true;
            }
        }
        return false;
    }

    private function usernameConatainBlacklistWord($userID) {
        $basicUsers = ['digster', 'topsify', 'spotify', 'filtr', 'sonymusic'];
        foreach ($basicUsers as $basicUser) {
            if ($this->startsWith($userID, $basicUser) || $this->endsWith($userID, $basicUser)) {
                return true;
            }
        }
        return false;
    }

    private function startsWith($string, $startString) {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

    private function endsWith($string, $endString) {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }

    public function recheckBlacklistUsers() {
        $blacklistUsers = SpotifyBlacklistUsers::whereDate('updated_at', '<>', Carbon::today())
                ->whereNotNull('updated_at')
                ->take(5)
                ->get();




        echo "<pre>";
        $bingController = new BingController();
        $numberOfMatches = $bingController->getBingResultsCount('sss');
        exit;


        foreach ($blacklistUsers as $blacklistUser) {

            $name = $blacklistUser->spotify_user_id;

//            if ($this->usernameConatainBlacklistWord($name)) {
//                $blacklistUser->touch();
//                $blacklistUser->save();
//                continue;
//            }


            $numberOfMatches = $bingController->getBingResultsCount($name);
            if ($numberOfMatches < 3000) {
                var_dump('*******************');
                var_dump("Name: {$name} Total: {$numberOfMatches} -> Deleted");
                $blacklistUser->delete();
            } else {
                $blacklistUser->touch();
                $blacklistUser->save();
            }
        }
    }

    /** This function will check the next 200 users if they exists or not
     * If they exists, will add them to spotify_users_table
     * 
     * @param Request $request
     */
    public function getNewUsersFromSpotify(Request $request) {
        $starttime = microtime(true);
        Log::channel('crawler_spotify_users_all')->info("Get new users from Spotify module waking up...");
        $currentSpotifyUsersCount = intval(Option::where('option_key', '=', 'crawler_current_users_run_number')->pluck('option_value')->first());
        $maximumPlaylistsToRun = 1000;

        $last = ($currentSpotifyUsersCount + $maximumPlaylistsToRun);
        Log::channel('crawler_spotify_users_all')->info("Fetching users {$currentSpotifyUsersCount}-{$last}");
        var_dump("Fetching users {$currentSpotifyUsersCount}-{$last}");
        $usersIDS = [];
        for ($i = 0; $i < $maximumPlaylistsToRun; $i++) {
            $usersIDS[] = $currentSpotifyUsersCount++;
        }
        shuffle($usersIDS);

        $spotifyController = new SpotifyController();

        $usersWithPlaylists = 0;
        $usersWithoutPlaylists = 0;
        $usersNotFound = 0;

        $usersToInsert = [];

        echo "<pre>";

        foreach ($usersIDS as $userID) {
            try {
                /* $userProfile = $spotifyController->doSpotifyRequest("users/{$userID}");
                  if (!$userProfile) {
                  $usersNotFound++;
                  continue;
                  } else {
                  print_r('********************');
                  print_r($userProfile);
                  $displayName = strtolower($userProfile['display_name']);
                  if ($this->spotifyNameContainMainUsers($displayName)) {
                  $usersWithPlaylists++;
                  continue;
                  }
                  } */
                $res = $spotifyController->doSpotifyRequest("users/{$userID}/playlists", ['limit' => 50]);

                if (!$res) {
                    $usersNotFound++;
                    continue;
                }

                if (!isset($res['items'])) {
                    $usersWithoutPlaylists++;
                    continue;
                }

                if (count($res['items']) > 0) {
                    $usersWithPlaylists++;
                    if (count($res['items']) < 50) {
                        $exists = SpotifyUsers::where('spotify_user_id', $userID)->first();
                        if (!$exists) {
                            $this->insertPlaylists($res['items'], $userID);
//                            $this->insertPlaylists($res['items'], $userID, $userProfile['display_name']);
                        }
                    } else {
                        $usersToInsert[] = $userID;
                    }
                } else {
                    $usersWithoutPlaylists++;
                }
            } catch (Exception $ex) {
                continue;
            }
        }

        $totalNewUsers = $this->insertSpotifyUsers($usersToInsert);


        var_dump("Users with playlists: {$usersWithPlaylists}");
        var_dump("Users without playlists: {$usersWithoutPlaylists}");
        var_dump("Users not found: {$usersNotFound}");

        $this->updateUsersModulesOptions($usersWithPlaylists, $usersWithoutPlaylists, $usersNotFound, $maximumPlaylistsToRun);

        $endtime = microtime(true);
        $timediff = $endtime - $starttime;

        var_dump("Total running time: {$timediff} seconds");

        Log::channel('crawler_spotify_users_all')->info('Get new users from Spotify module total time: ' . $timediff . ' seconds');
        Log::channel('crawler_spotify_users_all')->info("Get new users from Spotify module finished");

        $lastTimeRun = Option::where('option_key', '=', 'crawler_users_module_last_run')->first();
        $lastTimeRun->option_value = now();
        $lastTimeRun->save();
    }

    private function insertPlaylists($playlists, $userID) {
        $goodPlaylists = [];
        $userName = "";

        foreach ($playlists as $playlistItem) {
            if (isset($playlistItem['tracks']['total']) && $playlistItem['tracks']['total'] === 0 ||
                    isset($playlistItem['tracks']['total']) && $playlistItem['tracks']['total'] > 400 ||
                    $playlistItem['owner']['id'] != $userID ||
                    $playlistItem['name'] === "" ||
                    strpos(strtolower($playlistItem['name']), "soundtrack") !== false
            ) {
                continue;
            }
            $goodPlaylists[] = [
                'spotify_id' => $playlistItem['id'],
                'status' => 'playlist-exists',
                'priority' => 0,
                'created_at' => now()
            ];

            if ($userName === "" && $playlistItem['owner']['id'] === $userID) {
                $userName = $playlistItem['owner']['display_name'];
            }
        }
        $totalPlaylistsInserted = DB::table('playlists_crawler')->insertOrIgnore($goodPlaylists);


        // Create new spotify user
        $spotifyUser = new SpotifyUsers();
        $spotifyUser->spotify_user_id = $userID;
        $spotifyUser->spotify_user_name = $userName;
//        $spotifyUser->spotify_user_name = $displayName ? $displayName : $userName;
        $spotifyUser->status = $totalPlaylistsInserted > 0 ? "success" : "failed";
        $spotifyUser->total_playlists = $totalPlaylistsInserted;
        $spotifyUser->source = 'crawler_users_module';
        $spotifyUser->save();

        return true;
    }

    private function insertSpotifyUsers($usersIDS) {
        $spotifyUsers = [];

        foreach ($usersIDS as $userID) {
            $spotifyUsers[] = [
                'spotify_user_id' => $userID,
                'source' => 'crawler_users_module'
            ];
        }
        $totalNewUsers = DB::table('spotify_users')->insertOrIgnore($spotifyUsers);
        return $totalNewUsers;
    }

    private function updateUsersModulesOptions($usersWithPlaylists, $usersWithoutPlaylists, $usersNotFound, $totalPlaylistRunned) {

        if ($usersNotFound > 0) {
            Option::where('option_key', 'crawler_users_total_not_found')
                    ->update([
                        'option_value' => DB::raw('option_value+' . $usersNotFound)
            ]);
        }
        if ($usersWithPlaylists > 0) {
            Option::where('option_key', 'crawler_users_total_found_with_playlists')
                    ->update([
                        'option_value' => DB::raw('option_value+' . $usersWithPlaylists)
            ]);
        }
        if ($usersWithoutPlaylists > 0) {
            Option::where('option_key', 'crawler_users_total_found_without_playlists')
                    ->update([
                        'option_value' => DB::raw('option_value+' . $usersWithoutPlaylists)
            ]);
        }


        // Add 200 to counter
        Option::where('option_key', 'crawler_current_users_run_number')
                ->update([
                    'option_value' => DB::raw('option_value+' . $totalPlaylistRunned)
        ]);


        return true;
    }

    public function settings() {
        $words = ['aafafa', 'afafafrevrhg', 'gggg', 'gg r4rr'];


        return view('backend.crawler.settings', ['words' => $words]);
    }

    public function checkSpotifyStatus() {
        $spotifyController = new SpotifyController();
        $spotifyController->checkSpotifyStatus();

        exit;
    }

}
