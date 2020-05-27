<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/user' ,  'userController@showUser');
        Route::get('/reward_setting' ,  'rewardController@rewardShow');
        Route::get('/rewardGet' ,  'rewardController@rewardGet');
        Route::get('/category' ,  'rewardController@category');
        Route::get('/agent' ,  'userController@showAgent');

        // reward
        Route::post('/addReward' , 'rewardController@addReward');
        Route::post('/editReward' , 'rewardController@editReward');
        Route::get('/deleteReward' , 'rewardController@deleteReward');

        // category 
        Route::post('/addCategory' , 'rewardController@addCategory');
        Route::post('/editCategory' , 'rewardController@editCategory');
        Route::get('/deleteCategory' , 'rewardController@deleteCategory');

        // user 
        Route::post('/addUser' , 'userController@addUser');
        Route::post('/editUser' , 'userController@editUser');
        Route::get('/deleteUser' , 'userController@deleteUser');
        Route::post('/changePassword' , 'userController@changePassword');

        // agent 
        Route::post('/addAgent' , 'userController@addAgent');
        Route::post('/editAgent' , 'userController@editAgent');
        Route::get('/deleteAgent' , 'userController@deleteAgent');
            
        // game
        Route::get('/luckybox_setting' ,  'gameRewardController@Luckybox_show');
        Route::post('/addItem_inLuckybox' , 'gameRewardController@addItem_inLuckybox');
        Route::post('/editItem_inLuckybox' , 'gameRewardController@editItem_inLuckybox');
    });
});
/////////////////////////////////////////////////////////////////////////////// Get Reward /////////////////////////////////////////////////////////////////////////////

// Route::get('api/get_reward' , 'getRewardController@get_reward');