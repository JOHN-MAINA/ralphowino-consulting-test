<?php

use Illuminate\Http\Request;

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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('friends', 'FriendsController@get_friends');
    Route::get('friends/find', 'FriendsController@find_friends');
    Route::get('friends/request/{recipient_id}', 'FriendsController@send_request');
    Route::get('friends/requests', 'FriendsController@fetch_friend_requests');
    Route::get('friends/pending_friendships/{sender_id}', 'FriendsController@fetch_pending_friend_requests');
    Route::get('users/user/{id}', 'UserController@fetch_user');
    Route::get('friends/request/accept/{sender_id}', 'FriendsController@accept_friend_request');
    Route::get('friends/request/deny/{sender_id}', 'FriendsController@deny_friend_request');
    Route::get('friends/block/{sender_id}', 'FriendsController@block_user');
    Route::get('friends/blocked', 'FriendsController@fetch_blocked_users');
    Route::get('friends/unblocked/{friend_id}', 'FriendsController@unblock_user');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
