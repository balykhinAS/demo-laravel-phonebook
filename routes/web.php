<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/', 'UserController@index')->name('index');
    Route::get('/create', 'UserController@create')->name('create');
    Route::post('/', 'UserController@store')->name('store');
    Route::get('/{user}/edit', 'UserController@edit')->name('edit');
    Route::put('/{user}', 'UserController@update')->name('update');
    Route::delete('/{user}', 'UserController@delete')->name('delete');
    Route::delete('/', 'UserController@deleteSelect')->name('delete.select');
});

Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
    Route::post('/favorites-select', 'FavoriteController@addSelect')->name('favorites.add.select');
    Route::delete('/favorites-select', 'FavoriteController@removeSelect')->name('favorites.remove.select');

    Route::post('/{contact}/favorites', 'FavoriteController@add')->name('favorites.add');
    Route::delete('/{contact}/favorites', 'FavoriteController@remove')->name('favorites.remove');

    Route::get('/', 'ContactController@index')->name('index');
    Route::get('/create', 'ContactController@create')->name('create');
    Route::post('/', 'ContactController@store')->name('store');
    Route::get('/{contact}/edit', 'ContactController@edit')->name('edit');
    Route::put('/{contact}', 'ContactController@update')->name('update');
    Route::delete('/{contact}', 'ContactController@delete')->name('delete');
    Route::delete('/', 'ContactController@deleteSelect')->name('delete.select');

    Route::post('/export/{format}', 'ContactExportController@run')->name('export');
});

Route::group(['prefix' => 'cabinet', 'as' => 'cabinet.', 'namespace' => 'Cabinet', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', 'ProfileController@show')->name('show');
        Route::get('/edit', 'ProfileController@edit')->name('edit');
        Route::put('/', 'ProfileController@update')->name('update');
        Route::put('/api-token', 'ProfileController@refreshApiToken')->name('token.refresh');

        Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
            Route::get('/edit', 'ProfileController@editPassword')->name('edit');
            Route::put('/', 'ProfileController@updatePassword')->name('update');
        });
    });
});
