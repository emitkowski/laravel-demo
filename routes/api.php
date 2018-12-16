<?php

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


Route::group([/*'middleware' => 'auth:api',*/ 'namespace' => 'API\V1'], function () {

    // Users Routes
    Route::get('users', 'UserController@index');
    Route::get('users/paginate', 'UserController@paginate');
    Route::get('users/{id}', 'UserController@show');
    Route::post('users', 'UserController@store');
    Route::put('users/{id}', 'UserController@update');
    Route::delete('users/{id}', 'UserController@destroy');

    // Teams Routes
    Route::get('teams', 'TeamController@index');
    Route::get('teams/paginate', 'TeamController@paginate');
    Route::get('teams/{id}', 'TeamController@show');
    Route::post('teams', 'TeamController@store');
    Route::put('teams/{id}', 'TeamController@update');
    Route::delete('teams/{id}', 'TeamController@destroy');

    // Players Routes
    Route::get('players', 'PlayerController@index');
    Route::get('players/paginate', 'PlayerController@paginate');
    Route::get('players/{id}', 'PlayerController@show');
    Route::post('players', 'PlayerController@store');
    Route::put('players/{id}', 'PlayerController@update');
    Route::delete('players/{id}', 'PlayerController@destroy');

});