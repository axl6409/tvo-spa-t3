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
        Route::get('/data', 'Bungie\ProfileController@profileStats');
        Route::get('/character/{item}', 'Bungie\ProfileController@getCharacterInfos');
    });

    Route::prefix('/posts')->group( function () {
        Route::get('/all', 'Backend\PostController@index');
        Route::get('/create', 'Backend\PostController@create');
        Route::get('/edit/{id}', 'Backend\PostController@create');
        Route::post('/store', 'Backend\PostController@store');
        Route::post('/update', 'Backend\PostController@update');
        Route::delete('/delete/{id}', 'Backend\PostController@destroy');
    });

    Route::prefix('/medias')->group( function () {
        Route::get('/all', 'Backend\MediaController@index');
        Route::get('/edit', 'Backend\MediaController@edit');
        Route::post('/store', 'Backend\MediaController@store');
        Route::put('/update/{id}', 'Backend\MediaController@update');
        Route::delete('/delete/{id}', 'Backend\MediaController@destroy');
    });

    Route::prefix('/categories')->group( function () {
        Route::get('/all', 'Backend\CategoryController@index');
        Route::get('/edit', 'Backend\CategoryController@edit');
        Route::post('/store', 'Backend\CategoryController@store');
        Route::put('/update/{id}', 'Backend\CategoryController@update');
        Route::delete('/delete/{id}', 'Backend\CategoryController@destroy');
    });

    Route::prefix('/tags')->group( function () {
        Route::get('/all', 'Backend\TagController@index');
        Route::get('/edit', 'Backend\TagController@edit');
        Route::post('/store', 'Backend\TagController@store');
        Route::put('/update/{id}', 'Backend\TagController@update');
        Route::delete('/delete/{id}', 'Backend\TagController@destroy');
    });
});

Route::group(['middleware' => 'guest:api'], function () {

    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');

    Route::prefix('/posts')->group( function () {
        Route::get('/all', 'Frontend\PostController@all');
    });

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
