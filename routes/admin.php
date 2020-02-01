<?php

use App\Library\Permissions;
use App\Library\Roles;

Route::middleware(['auth', 'permission:' . Permissions::view_admin_panel])
    ->namespace('Admin')->prefix('admin')->group(function () {

        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

        /**
         * ContentController
         */
        Route::middleware('permission:' . Permissions::create_content)->group(function () {
            Route::get('content/create', 'ContentController@create')->name('admin.content.create');
            Route::post('content', 'ContentController@store')->name('admin.content.store');
        });
        Route::middleware('permission:' . Permissions::restore_content)->group(function () {
            Route::get('content/trash', 'ContentController@trash')->name('admin.content.trash');
            Route::post('content/restore', 'ContentController@restore')->name('admin.content.restore');
        });
        Route::middleware('permission:' . Permissions::view_content)->group(function () {
            Route::get('content', 'ContentController@index')->name('admin.content.index');
            Route::get('content/{content}', 'ContentController@show')->name('admin.content.show');
            Route::get('content/{content}/log', 'ContentController@log')->name('admin.content.log');
//            Route::get('content/{content}/audio/move', 'ContentController@moveAudio')->name('admin.content.audio.move');
            Route::get('content/{content}/export', 'ContentController@export')->name('admin.content.export');
            Route::get('content/{content}/export/json', 'ContentController@exportJson')->name('admin.content.export.json');
            Route::post('content/{content}/import/json', 'ContentController@importJson')->name('admin.content.import.json');
        });
//        Route::middleware('permission:' . Permissions::update_content)->group(function () {
//            Route::get('content/{content}/edit', 'ContentController@edit')->name('admin.content.edit');
//            Route::patch('content/{content}', 'ContentController@update')->name('admin.content.update');
//        });
        Route::middleware('permission:' . Permissions::delete_content)->group(function () {
            Route::delete('content/{content}', 'ContentController@destroy')->name('admin.content.destroy');
        });
        Route::middleware('permission:' . Permissions::assign_editors)->group(function () {
            Route::get('content/{content}/editors', 'ContentController@editors')->name('admin.content.editors.index');
            Route::post('content/{content}/editors/assign', 'ContentController@assignEditor')->name('admin.content.editors.assign');
            Route::post('content/{content}/editors/remove', 'ContentController@removeEditor')->name('admin.content.editors.remove');
        });

        /**
         * LessonController
         */
        Route::middleware('permission:' . Permissions::view_content)->group(function () {
            Route::get('content/lessons/{lesson}', 'LessonController@show')->name('admin.lessons.show');
            Route::get('content/lessons/{lesson}/log', 'LessonController@log')->name('admin.lessons.log');
        });
        Route::middleware('permission:' . Permissions::update_content)->group(function () {
            Route::get('content/{content}/lessons/create', 'LessonController@create')->name('admin.lessons.create');
            Route::post('content/{content}/lessons', 'LessonController@store')->name('admin.lessons.store');
            Route::get('content/lessons/{lesson}/edit', 'LessonController@edit')->name('admin.lessons.edit');
            Route::patch('content/lessons/{lesson}', 'LessonController@update')->name('admin.lessons.update');
            Route::patch('content/lessons/move', 'LessonController@move')->name('admin.lessons.move');
            Route::delete('content/lessons/{lesson}', 'LessonController@destroy')->name('admin.lessons.destroy');
            Route::get('content/{content}/lessons/trash', 'LessonController@trash')->name('admin.lessons.trash');
            Route::post('content/lessons/restore', 'LessonController@restore')->name('admin.lessons.restore');
        });

        /**
         * ExerciseController
         */
        Route::middleware('permission:' . Permissions::view_content)->group(function () {
            Route::get('content/exercises/{exercise}', 'ExerciseController@show')->name('admin.exercises.show');
            Route::get('content/exercises/{exercise}/log', 'ExerciseController@log')->name('admin.exercises.log');
        });
        Route::middleware('permission:' . Permissions::update_content)->group(function () {
            Route::post('content/lessons/{lesson}/exercises', 'ExerciseController@store')->name('admin.exercises.store');
            Route::patch('content/exercises/move', 'ExerciseController@move')->name('admin.exercises.move');
            Route::delete('content/exercises/{exercise}', 'ExerciseController@destroy')->name('admin.exercises.destroy');
            Route::get('content/lessons/{lesson}/exercises/trash', 'ExerciseController@trash')->name('admin.exercises.trash');
            Route::post('content/exercises/restore', 'ExerciseController@restore')->name('admin.exercises.restore');
        });

        /**
         * ExerciseFieldController
         */
        Route::middleware('permission:' . Permissions::update_content)->group(function () {
            Route::post('content/exercises/{exercise}/fields', 'ExerciseFieldController@store')->name('admin.exercise.fields.store');
            Route::patch('content/exercise/fields/{exerciseField}', 'ExerciseFieldController@update')->name('admin.exercise.fields.update');
            Route::patch('content/exercise/fields/{exerciseField}/audio/synthesize', 'ExerciseFieldController@synthesizeAudio')->name('admin.exercise.fields.audio.synthesize');
            Route::patch('content/exercise/fields/{exerciseField}/audio/delete', 'ExerciseFieldController@deleteAudio')->name('admin.exercise.fields.audio.delete');
            Route::patch('content/exercise/fields/move', 'ExerciseFieldController@move')->name('admin.exercise.fields.move');
            Route::delete('content/exercise/fields/{exerciseField}', 'ExerciseFieldController@destroy')->name('admin.exercise.fields.destroy');
            Route::get('content/exercises/{exercise}/fields/trash', 'ExerciseFieldController@trash')->name('admin.exercise.fields.trash');
            Route::post('content/exercise/fields/restore', 'ExerciseFieldController@restore')->name('admin.exercise.fields.restore');
        });

        /**
         * TranslationController
         */
        Route::middleware('permission:' . Permissions::view_translations)->group(function() {
            Route::get('translations/{language}/content/{content}', 'TranslationController@showContent')->name('admin.translations.content.show');
            Route::get('translations/{language}/lessons/{lesson}', 'TranslationController@showLesson')->name('admin.translations.lesson.show');
            Route::get('translations/{language}/exercises/{exercise}', 'TranslationController@showExercise')->name('admin.translations.exercise.show');
            Route::get('translations/{language}/content/{content}/export', 'TranslationController@export')->name('admin.translations.content.export');
        });
        Route::middleware('permission:' . Permissions::update_translations)->group(function() {
            Route::patch('translations/{translation}', 'TranslationController@update')->name('admin.translations.exercise.fields.update');
            Route::patch('translations/{translation}/audio/synthesize', 'TranslationController@synthesizeAudio')->name('admin.translations.audio.synthesize');
            Route::patch('translations/{translation}/audio/delete', 'TranslationController@deleteAudio')->name('admin.translations.audio.delete');
        });
        Route::middleware('permission:' . Permissions::assign_editors)->group(function() {
            Route::get('translations/{language}/content/{content}/editors', 'TranslationController@editors')->name('admin.translations.editors.index');
            Route::post('translations/{language}/content/{content}/editors/assign', 'TranslationController@assignEditor')->name('admin.translations.editors.assign');
            Route::post('translations/{language}/content/{content}/editors/remove', 'TranslationController@removeEditor')->name('admin.translations.editors.remove');
        });
        Route::middleware('permission:' . Permissions::publish_courses)->group(function() {
            Route::post('translations/{language}/content/{content}/commit', 'TranslationController@commit')->name('admin.translations.commit');
        });

        /**
         * PractiseController
         */
        Route::middleware('permission:' . Permissions::view_translations)->group(function() {
            Route::get('practise/translations/{language}/lessons/{lesson}/listening', 'PractiseController@listening')->name('admin.practise.listening');
            Route::get('practise/translations/{language}/lessons/{lesson}/speaking', 'PractiseController@speaking')->name('admin.practise.speaking');
        });

        /**
         * Courses
         */
        Route::middleware('permission:' . Permissions::view_courses)->group(function() {
            Route::get('courses', 'CourseController@index')->name('admin.courses.index');
            Route::get('courses/{course}', 'CourseController@show')->name('admin.courses.show');
        });
        Route::middleware('permission:' . Permissions::assign_editors)->group(function() {
            Route::get('courses/{course}/edit', 'CourseController@edit')->name('admin.courses.edit');
            Route::patch('courses/{course}', 'CourseController@update')->name('admin.courses.update');
        });

        /**
         * Languages
         */
        Route::middleware('role:' . Roles::admin)->group(function() {
            Route::get('languages', 'LanguageController@index')->name('admin.languages.index');
            Route::get('languages/create', 'LanguageController@create')->name('admin.languages.create');
            Route::post('languages', 'LanguageController@store')->name('admin.languages.store');
            Route::get('languages/{language}/edit', 'LanguageController@edit')->name('admin.languages.edit');
            Route::patch('languages/{language}', 'LanguageController@update')->name('admin.languages.update');
        });

        /**
         * Jobs
         */
        Route::get('jobs/{jobStatus}/status', 'JobController@status')->name('admin.jobs.status');
    });
