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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('get_reward' , 'getRewardController@get_reward');
Route::get('get_reward/{id}' , 'getRewardController@get_reward_id');
Route::post('user_exchange' , 'getRewardController@user_exchange');
Route::post('login_user' , 'getRewardController@login_user');

//////////////////////////// Game API /////////////////////////////////
Route::post('calculate_point' , 'gameRewardController@play_game_reward');
Route::post('buy_box_amount' , 'gameRewardController@buy_box_amount');
Route::get('randombox' , 'gameRewardController@randombox');