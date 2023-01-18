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
    // Route::post('register', [App\Http\Controllers\API\RegisterController::class, 'register']);

    Route::post('login', 'RegisterController@login');
    
    Route::middleware('auth:api')->group( function () {
        Route::post('logout', 'RegisterController@logout');

        Route::group(['prefix' => 'setting'], function(){
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

Route::namespace('App\\Http\\Controllers')->group(function () {
    Route::get('loadLGA/{id}', 'FreeController@loadLGA');

    Route::middleware('auth:api')->group( function () {
        //Member Sections
        Route::group(['prefix' => 'section'], function(){
            Route::get('', 'SectionController@index');
            Route::get('delete', 'SectionController@destroy');
            Route::get('{id}', 'SectionController@view');
            Route::put('{id}', 'SectionController@update');
            Route::post('', 'SectionController@store');
        });

        //Member types
        Route::group(['prefix' => 'type'], function(){
            Route::get('', 'TypeController@index');
            Route::get('delete', 'TypeController@destroy');
            Route::get('{id}', 'TypeController@view');
            Route::put('{id}', 'TypeController@update');
            Route::post('', 'TypeController@store');
        });

        //Payment Products
        Route::group(['prefix' => 'payment'], function(){
            Route::group(['prefix' => 'Product'], function(){
                Route::get('', 'ProductController@index');
                Route::get('delete', 'ProductController@destroy');
                Route::get('{id}', 'ProductController@view');
                Route::put('{id}', 'ProductController@update');
                Route::post('', 'ProductController@store');
            });
        });

        Route::group(['prefix' => 'members'], function(){
            Route::get('', 'MemberController@index');
            Route::get('delete', 'MemberController@destroy');
            Route::get('details', 'MemberController@details');
            Route::get('{id}', 'MemberController@view');
            Route::put('{id}', 'MemberController@update');
            Route::post('', 'MemberController@store');
        });
    });
});


