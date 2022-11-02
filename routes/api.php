<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::name('backend.')->prefix('v1/subscriptions')->namespace('Backend')->middleware(['auth', 'role:admin'])->group(function () {

Route::prefix('v1/subscriptions')->namespace('Backend')->group(function () {
    Route::post('/updateUserSubscriptionFromStripe', 'SubscriptionController@updateSubscription')->name('subscriptions.updateUserSubscriptionFromStripe');
    Route::get('/extendFreeUsersSubscriptions', 'SubscriptionController@extendFreeUsersSubscriptions')->name('subscriptions.extendFreeUsersSubscriptions');
    Route::get('/updateExpiredPaidSubscriptions', 'SubscriptionController@updateExpiredPaidSubscriptions')->name('subscriptions.updateExpiredPaidSubscriptions');
    Route::post('/subscribeToPaypal', 'SubscriptionController@subscribeToPaypal')->name('subscriptionpaypal.checkout');
    Route::post('/cancelPaypalSubscription', 'SubscriptionController@cancelPaypalSubscriptionHook')->name('subscriptionpaypal.cancelhook');
    
    
    Route::post('/updateUserSubscriptionFromPaypal', 'SubscriptionController@updatePaypalSubscription')->name('subscriptions.updateUserSubscriptionFromPaypal');
   
});

//
//Route::prefix('v1/subscriptions')->namespace('Frontend')->group(function () {
//    Route::post('/subscribeToPaypal', 'SubscriptionController@subscribeToPaypal')->name('subscriptionpaypal.checkout');
//});

