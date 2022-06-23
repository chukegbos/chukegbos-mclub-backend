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

Route::namespace('App\\Http\\Controllers\\API')->group(function () {
    //   Route::post('register', [App\Http\Controllers\API\RegisterController::class, 'register']);
    //Route::post('login', [RegisterController::class, 'login']);   
    Route::post('login', 'RegisterController@login');
    Route::post('logout', 'RegisterController@logout');
    
    Route::middleware('auth:api')->group( function () {
        Route::group(['prefix' => 'setting'], function(){
            Route::get('', 'SettingController@index');
            Route::get('me', 'SettingController@me');
            Route::put('{id}', 'SettingController@update');
            Route::put('standard/{id}', 'SettingController@standardupdate');

            Route::group(['prefix' => 'session'], function(){
                Route::get('', 'SessionController@index');
                Route::get('delete', 'SessionController@destroy');
                Route::get('{id}', 'SessionController@view');
                Route::put('{id}', 'SessionController@update');
                Route::post('', 'SessionController@create');
            });
        });
    });
});




