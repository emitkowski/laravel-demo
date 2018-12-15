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
| Customer Routes
|--------------------------------------------------------------------------
|
| Routes for public users of application
|
*/

Route::get('/', 'WelcomeController@show');

// Authenticated User Routes
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@show')->name('home');

    Route::resource('users', 'UserController');
    Route::resource('teams', 'TeamController');

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
| User Auth Routes
|--------------------------------------------------------------------------
|
| Routes for authentication of users of application
|
*/

Auth::routes();

/*
|--------------------------------------------------------------------------
| Examples Routes
|--------------------------------------------------------------------------
|
| Routes for examples valid only in test environments
|
*/

Route::group(['namespace' => 'Examples'], function () {

    if (app()->environment() !== 'production') {
        Route::get('test', 'TestController@index');
        Route::get('test/text', 'TestController@text');
        Route::get('test/log', 'TestController@log');
    }
});

/*
|--------------------------------------------------------------------------
| Development Routes
|--------------------------------------------------------------------------
|
| Routes for developer information
|
*/

Route::get('env', function () {
    dd(app()->environment());
});

Route::get('info', function () {
    if (app()->environment() !== 'production') {
        phpinfo();
    }
});