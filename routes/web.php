<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::get('/', function () {
    return view('index');
})->name('home');

//Route::get('/dashboard', function () {
//    return view('backend.index');
//})->middleware(['auth'])->name('dashboard');

Route::view('/privacy', 'pages.privacy')->name('pages.privacy');
Route::view('/terms', 'pages.terms')->name('pages.terms');
Route::view('/how-to-use', 'pages.how_to_use')->name('pages.how_to_use');
Route::view('/about', 'pages.about')->name('pages.about');
Route::view('/contact', 'pages.contact')->name('pages.contact');
Route::view('/faq', 'pages.faq')->name('pages.faq');
//Route::view('/pricing', 'pages.pricing')->name('pages.pricing');
Route::view('/testGmail', 'testGmail');



//Route::get('/paypalSuccessfullySubscribe', 'PaypalController@subscribeToPaypal');

/* Backend Routes */
Route::name('backend.')->prefix('backend')->namespace('Backend')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
//    Route::view('/', 'backend.index')->name('dashboard');
    Route::post('playlists/import', 'PlaylistController@import')->name('playlists.import');
    Route::get('playlists/export', 'PlaylistController@export')->name('playlists.export');
    Route::resource('playlists', 'PlaylistController');
    Route::resource('users', 'UserController');
    Route::resource('templates', 'TemplateController');
    Route::resource('tags', 'TagController');


    Route::post('spotifyUsers/moveToBlacklist', 'SpotifyUsersController@moveToBlacklist');
    Route::post('spotifyUsers/moveToWhitelist', 'SpotifyUsersController@moveToWhitelist');


    Route::get('crawler/words', 'PlaylistCrawlerController@getWords')->name('crawler.words');
    Route::get('crawler/spotifyUsers', 'PlaylistCrawlerController@getSpotifyUsers')->name('crawler.spotify_users');
    Route::get('crawler/spotifyBlacklistUsers', 'PlaylistCrawlerController@getSpotifyBlacklistUsers')->name('crawler.spotify_blacklist_users');
    Route::get('crawler/playlistsStatistics', 'PlaylistCrawlerController@getPlaylistsStatisticsView')->name('crawler.playlists_statistics');
    Route::get('crawler/settings', 'PlaylistCrawlerController@settings')->name('crawler.settings');
    Route::resource('crawler', 'PlaylistCrawlerController');
    Route::get('crawler/dashboard', 'PlaylistCrawlerController@dashboard')->name('crawler.dashboard');


    Route::resource('reported-playlists', 'ReportedPlaylistController')->only([
        'index', 'destroy'
    ]);

    Route::get('/plans', 'PlanController@index')->name('plans.index');
    Route::post('/plans', 'PlanController@update')->name('plans.update');
    Route::get('/reported-playlists', 'PlaylistController@reportedPlaylists')->name('playlists.reported');
    Route::resource('subscriptions', 'SubscriptionController')->only(['index', 'destroy']);
});


Route::name('backend.')->prefix('backend')->namespace('Backend')->group(function () {
    Route::get('/updateSpotifyPlaylists', 'PlaylistController@updatePlaylistFromSpotify');
    Route::get('/runPlaylistsCrawler', 'PlaylistCrawlerController@runPlaylistsCrawler');
    Route::get('/runSpotifyPlaylistCrawlerCheck', 'PlaylistCrawlerController@runSpotifyPlaylistCrawlerCheck');
    Route::get('/runSpotifyPlaylistCrawlerEmailCheck', 'PlaylistCrawlerController@runSpotifyPlaylistCrawlerEmailCheck');
    Route::get('/getNewPlaylistsToCrawler', 'PlaylistCrawlerController@getNewPlaylistsToCrawler');
    Route::get('/getNewPlaylistsFromUsers', 'PlaylistCrawlerController@getNewPlaylistsFromUsers');
    Route::get('/updateCrawlerStatistics', 'PlaylistCrawlerController@updateCrawlerStatistics');
    Route::get('/testCrawler', 'PlaylistCrawlerController@test');
    Route::get('/checkSpotifyStatus', 'PlaylistCrawlerController@checkSpotifyStatus');
    Route::get('/recheckBlacklistUsers', 'PlaylistCrawlerController@recheckBlacklistUsers');
    Route::get('/getNewUsersFromSpotify', 'PlaylistCrawlerController@getNewUsersFromSpotify');
});


Route::name('frontend.')->namespace('Frontend')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/sendgrid', 'SendgridTest@test')->name('profile')->withoutMiddleware(['verified']);

    Route::get('/profile', 'ProfileController@index')->name('profile')->withoutMiddleware(['verified']);
    Route::get('/myplaylist', 'ProfileController@myplaylist')->name('myplaylist')->withoutMiddleware(['verified']);
    Route::get('/profile/security', 'ProfileController@security')->name('security')->withoutMiddleware(['verified']);
    Route::get('/profile/subscription', 'ProfileController@subscription')->name('subscription')->withoutMiddleware(['verified']);
    Route::post('/profile', 'ProfileController@update')->name('profile.update')->withoutMiddleware(['verified']);
    Route::post('/updateSpotifyArtist', 'ProfileController@updateSpotifyArtist')->name('profile.update-spotify-artist')->withoutMiddleware(['verified']);



    Route::get('/manage-plans', 'ProfileController@plans')->name('profile.plans');
    Route::get('/browse', 'FrontendController@search')->name('search');
    Route::get('/browse/guest', 'FrontendController@searchGuest')->name('search.guest')->withoutMiddleware(['verified', 'auth']);
    Route::post('/playlists/report', 'FrontendController@reportPlaylist')->name('playlists.report');
    Route::post('/playlists/unlock', 'FrontendController@unlockPlaylist')->name('playlists.unlock');



    Route::get('/message-generator/{playlist}', 'MessageGeneratorController@index')->name('message-generator');
    Route::post('/message-generator/{playlist}/change-template', 'MessageGeneratorController@changeTemplate')->name('message_generator.change_template');

    Route::post('/upgrade-plan/checkout', 'SubscriptionController@checkout')->name('subscription.checkout');
    Route::post('/cancel-subscription', 'SubscriptionController@cancel')->name('subscription.cancel');

//    Route::post('/subscribeToPaypal', 'SubscriptionController@subscribeToPaypal')->name('subscriptionpaypal.checkout');
    Route::post('/subscribeToPaypal', 'SubscriptionController@subscribeToPaypal')->name('subscriptionpaypal.checkout');
    Route::get('/updatePaypalSubscription', 'SubscriptionController@updatePaypalSubscription')->name('subscriptionpaypalupdate.checkout');
    Route::get('/changePaypalSubscription', 'SubscriptionController@changePaypalSubscription')->name('subscriptionpaypalchange.checkout');
    Route::post('/getPaypalNewPlanURL', 'SubscriptionController@getPaypalNewPlanURL')->name('subscriptionpaypal.change');



    Route::get('/validateStripeCoupon/{couponID}', 'FrontendController@validateStripeCoupon');

    
   
    
    
    //Tests
    Route::get('/testPlan', 'SubscriptionController@testNewPlan'); 
});



Route::name('frontend.')->namespace('Frontend')->group(function () {
    Route::get('getSpotifyArtistsByName/{name}', 'FrontendController@getSpotifyArtistsByName')->name('frontendcontroller.getSpotifyArtistsByName');
    Route::get('curator/{playlistID}', 'CuratorController@getPlaylistPage');

    Route::get('/pricing', 'ProfileController@plans')->name('profile.plans');

    
     Route::get('/spotify-login', 'SocialController@loginWithSpotify'); 
     Route::get('/google-login', 'SocialController@loginWithGoogle'); 
     Route::post('/loginWithGoogle', 'SocialController@loginWithGoogle');
    
//    Route::post('/validateStripeCoupon', 'FrontendController@validateStripeCoupon');
//    Route::post('/validateStripeCoupon', 'FrontendController@validateStripeCoupon');
//    Route::resource('playlists', 'PlaylistController');
});

Route::get('/verify-email/{id}/{hash}', 'UserController@verifyEmailAndLogIn')
        ->name('verification.verify.new');

require __DIR__ . '/auth.php';

// Testsssssssssssss //
//use Storage;
//use \Storage;
Route::get('/testImage', function () {

    $imagePath = 'https://i.scdn.co/image/ab6761610000e5eb7608a0bf48db9ed12f476ba5';

    $url = $imagePath;
    $contents = file_get_contents($url);
//    $name = substr($url, strrpos($url, '/') + 1);
    $filename = random_bytes(20) . ".jpg";
    var_dump($filename);
    $path = Storage::put('public/images/users/' . $filename, $contents);
    var_dump($path);
});

