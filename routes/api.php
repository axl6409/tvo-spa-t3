<?php

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

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/home', 'Frontend\HomeController@home');
    Route::get('/user', 'Auth\UserController@current');
    Route::get('/profile', 'Bungie\ProfileController@index');
    Route::prefix('/manifest')->group( function () {
      Route::get('/check', 'Bungie\ManifestController@checkManifest');
      Route::get('/tables', 'Bungie\ManifestController@getAllTables');
      Route::get('/query/{table}/{id}', 'Bungie\ManifestController@getSingleDefinition');
      Route::get('/definition/{def}', 'Bungie\ManifestController@getDefinition');
    });
    Route::prefix('/profile')->group( function () {
        Route::get('/all', 'Bungie\ProfileController@index');
        Route::get('/characters', 'Bungie\ProfileController@characters');
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
