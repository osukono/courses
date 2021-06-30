<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {

    Route::get('/', 'WebController@index')->name('welcome');

    Auth::routes();

//    Route::get('teachers', 'WebController@teachers')->name('teachers');

    Route::get('grammar/{courseLesson}', 'GrammarController@show')->name('grammar');

    Route::get('download', 'DownloadController@index')->name('download');

    Route::get('privacy-policy', 'DocumentController@privacy')->name('privacy');

    Route::middleware('auth')->group(function () {
        Route::post('user/settings/save', 'UserController@saveSettings')->name('user.settings.save');
    });

});
