<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function () {

    Route::get('/', 'WebController@index')->name('welcome');

    Auth::routes();

    Route::get('download', 'DownloadController@index')->name('download');

    Route::get('privacy-policy', 'DocumentController@privacy')->name('privacy');

    Route::middleware('auth')->group(function () {
//        Route::get('/home', 'HomeController@index')->name('home');
//        Route::get('practice/{course}', 'CourseController@practice')->name('courses.practice');
//        Route::get('practice/{course}/lesson-{number}', 'CourseController@practiceLesson')->name('courses.practice.lesson');
//        Route::post('courses/{course}/progress/reset', 'CourseController@resetProgress')->name('courses.progress.reset');
//        Route::get('courses/{course}/progress/{key}', 'CourseController@updateProgress')->name('courses.progress.update');

//        Route::get('unsubscribe', 'UserController@unsubscribe')->name('user.unsubscribe');

        Route::post('user/settings/save', 'UserController@saveSettings')->name('user.settings.save');
    });

});
