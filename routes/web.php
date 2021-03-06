<?php

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

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Routes for public users of application
|
*/

// Authenticated User Routes
Route::group(['middleware' => 'auth'], function () {

    // Home
    Route::get('/', 'HomeController@show')->name('home');

    // Teams
    Route::get('teams', 'TeamController@index')->name('teams.index');
    Route::get('teams/{team}', 'TeamController@show')->name('teams.show');

    // Players
    Route::get('players', 'PlayerController@index')->name('players.index');
    Route::get('players/{player}', 'PlayerController@show')->name('players.show');

    // Geo
    Route::get('geo/states', 'GeoController@states')->name('geo.states');
    Route::get('geo/countries', 'GeoController@countries')->name('geo.countries');

    // Attachments
    Route::get('attachment/{type}/{id}/{group?}', 'AttachmentController@index')->name('attachment.index');
    Route::get('attachments/{id}/{name}', 'AttachmentController@download')->name('attachments.download');
    Route::post('attachment/{type}/{id}', 'AttachmentController@store')->name('attachment.store');
    Route::delete('attachment/{uuid}', 'AttachmentController@destroy')->name('attachment.delete');

    // Addresses
    Route::get('address/{type}/{id}', 'AddressController@index')->name('address.index');
    Route::post('address/{type}/{id}', 'AddressController@store')->name('address.store');
    Route::put('address/{address}', 'AddressController@update')->name('address.update');
    Route::put('address/default/{address}', 'AddressController@setDefault')->name('address.default');
    Route::delete('address/{address}', 'AddressController@destroy')->name('address.delete');
});


/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Routes for authentication of users of application
|
*/

Auth::routes();