<?php

use App\Library\Permissions;
use App\Library\Roles;

Route::middleware(['auth', 'permission:' . Permissions::view_admin_panel])
    ->namespace('Admin')->prefix('console')->group(function () {

        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

        /**
         * ContentController
         */
        Route::middleware('permission:' . Permissions::create_content)->group(function () {
            Route::get('content/create', 'ContentController@create')->name('admin.content.create');
            Route::post('content', 'ContentController@store')->name('admin.content.store');
        });
        Route::middleware('permission:' . Permissions::update_content)->group(function () {
            Route::get('content/{content}/edit', 'ContentController@edit')->name('admin.content.edit');
            Route::patch('content/{content}', 'ContentController@update')->name('admin.content.update');
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
            Route::get('content/{content}/export', 'ContentController@exportText')->name('admin.content.export');
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
            Route::patch('content/{content}/editors/assign', 'ContentController@assignEditor')->name('admin.content.editors.assign');
            Route::patch('content/{content}/editors/remove', 'ContentController@removeEditor')->name('admin.content.editors.remove');
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
            Route::patch('content/lessons/{lesson}/disable', 'LessonController@disable')->name('admin.lessons.disable');
            Route::patch('content/lessons/{lesson}/enable', 'LessonController@enable')->name('admin.lessons.enable');
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
            Route::patch('content/exercises/{exercise}/disable', 'ExerciseController@disable')->name('admin.exercises.disable');
            Route::patch('content/exercises/{exercise}/enable', 'ExerciseController@enable')->name('admin.exercises.enable');
        });

        /**
         * ExerciseDataController
         */
        Route::middleware('permission:' . Permissions::update_content)->group(function() {
            Route::post('content/exercises/{exercise}/data/create', 'ExerciseDataController@store')->name('admin.exercise.data.create');
            Route::patch('content/exercise/data/{exerciseData}', 'ExerciseDataController@update')->name('admin.exercise.data.update');
            Route::patch('content/exercise/data/{exerciseData}/audio/synthesize', 'ExerciseDataController@synthesizeAudio')->name('admin.exercise.data.audio.synthesize');
            Route::patch('content/exercise/data/{exerciseData}/audio/delete', 'ExerciseDataController@deleteAudio')->name('admin.exercise.data.audio.delete');
            Route::patch('content/exercise/data/move', 'ExerciseDataController@move')->name('admin.exercise.data.move');
            Route::delete('content/exercise/data/{exerciseData}', 'ExerciseDataController@destroy')->name('admin.exercise.data.destroy');
            Route::get('content/exercises/{exercise}/data/trash', 'ExerciseDataController@trash')->name('admin.exercise.data.trash');
            Route::post('content/exercise/data/restore', 'ExerciseDataController@restore')->name('admin.exercise.data.restore');
            Route::patch('content/exercise/data/{exerciseData/disable/{language}', 'ExerciseDataController@disable')->name('admin.exercise.data.disable');
            Route::patch('content/exercise/data/{exerciseData/enable/{language}','ExerciseDataController@enable')->name('admin.exercise.data.enable');
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
            Route::patch('translations/{translation}', 'TranslationController@update')->name('admin.translations.exercise.data.update');
            Route::patch('translations/{translation}/audio/synthesize', 'TranslationController@synthesizeAudio')->name('admin.translations.audio.synthesize');
            Route::patch('translations/{translation}/audio/delete', 'TranslationController@deleteAudio')->name('admin.translations.audio.delete');
            Route::patch('translations/{language}/lessons/{lesson}/disable', 'TranslationController@disableLesson')->name('admin.translations.lesson.disable');
            Route::patch('translations/{language}/lessons/{lesson}/enable', 'TranslationController@enableLesson')->name('admin.translations.lesson.enable');
            Route::patch('translations/{language}/exercises/{exercise}/disable', 'TranslationController@disableExercise')->name('admin.translations.exercise.disable');
            Route::patch('translations/{language}/exercises/{exercise}/enable', 'TranslationController@enableExercise')->name('admin.translations.exercise.enable');
        });
        Route::middleware('permission:' . Permissions::assign_editors)->group(function() {
            Route::get('translations/{language}/content/{content}/editors', 'TranslationController@editors')->name('admin.translations.editors.index');
            Route::patch('translations/{language}/editors/assign', 'TranslationController@assignEditor')->name('admin.translations.editors.assign');
            Route::patch('translations/{language}/editors/remove', 'TranslationController@removeEditor')->name('admin.translations.editors.remove');
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
            Route::get('courses/{course}/practice/lessons/{courseLesson}', 'CourseController@practice')->name('admin.courses.practice');
        });
        Route::middleware('permission:' . Permissions::publish_courses)->group(function() {
            Route::post('courses/{course}/firestore/upload', 'CourseController@firestoreUpload')->name('admin.courses.firestore.upload');
            Route::post('courses/{course}/firestore/update', 'CourseController@firestoreUpdate')->name('admin.courses.firestore.update');
            Route::delete('courses/{course}/delete', 'CourseController@delete')->name('admin.courses.delete');
            Route::post('courses/{course}/image/upload', 'CourseController@uploadImage')->name('admin.courses.image.upload');
            Route::post('courses/{course}/updating/switch', 'CourseController@switchIsUpdating')->name("admin.courses.updating.switch");
        });
        Route::middleware('permission:' . Permissions::update_courses)->group(function() {
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
            Route::post('languages/{language}/icon/upload', 'LanguageController@uploadIcon')->name('admin.languages.icon.upload');
            Route::post('languages/{language}/sync', 'LanguageController@sync')->name('admin.languages.firestore.sync');
        });

        /**
         * App Locales
         */
        Route::middleware('role:' . Roles::admin)->group(function() {
            Route::get('app/locales', 'AppLocaleController@index')->name('admin.app.locales.index');
            Route::post('app/locales/download', 'AppLocaleController@download')->name('admin.app.locales.download');
            Route::post('app/locales/upload', 'AppLocaleController@upload')->name('admin.app.locales.upload');
            Route::get('app/locales/create', 'AppLocaleController@create')->name('admin.app.locales.create');
            Route::post('app/locales', 'AppLocaleController@store')->name('admin.app.locales.store');
            Route::get('app/locales/{appLocale}/edit', 'AppLocaleController@edit')->name('admin.app.locales.edit');
            Route::patch('app/locales/{appLocale}', 'AppLocaleController@update')->name('admin.app.locales.update');
            Route::delete('app/locales/{appLocale}', 'AppLocaleController@delete')->name('admin.app.locales.delete');

            Route::get('app/locale/groups', 'LocaleGroupController@index')->name('admin.app.locale.groups.index');
            Route::get('app/locale/groups/create', 'LocaleGroupController@create')->name('admin.app.locale.groups.create');
            Route::post('app/locale/groups/store', 'LocaleGroupController@store')->name('admin.app.locale.groups.store');
            Route::get('app/locale/groups/{localeGroup}/edit', 'LocaleGroupController@edit')->name('admin.app.locale.groups.edit');
            Route::patch('app/locale/groups/{localeGroup}', 'LocaleGroupController@update')->name('admin.app.locale.groups.update');
        });

        /**
         * Speech Settings
         */
        Route::middleware('permission:' . Permissions::update_content)->group(function() {
            Route::get('content/{content}/speech/settings/edit', 'SpeechSettingsController@editContentSettings')->name('admin.content.speech.settings.edit');
            Route::post('content/{content}/speech/settings', 'SpeechSettingsController@updateContentSettings')->name('admin.content.speech.settings.update');
        });
        Route::middleware('permission:' . Permissions::update_translations)->group(function() {
            Route::get('translations/{language}/content/{content}/speech/settings/edit', 'SpeechSettingsController@editTranslationSettings')->name('admin.translations.speech.settings.edit');
            Route::post('translations/{language}/content/{content}/speech/settings', 'SpeechSettingsController@updateTranslationSettings')->name('admin.translations.speech.settings.update');
        });

        /**
         * Player Settings
         */
        Route::middleware('role:' . Roles::admin)->group(function() {
            Route::get('languages/{language}/player/settings/create', 'PlayerSettingsController@create')->name('admin.player.settings.create');
            Route::post('languages/{language}/player/settings', 'PlayerSettingsController@store')->name('admin.player.settings.store');
            Route::get('languages/{language}/player/settings/edit', 'PlayerSettingsController@edit')->name('admin.player.settings.edit');
            Route::patch('languages/{language}/player/settings', 'PlayerSettingsController@update')->name('admin.player.settings.update');
        });

        /**
         * Topics
         */
        Route::middleware('role:' . Roles::admin)->group(function() {
            Route::get('topics', 'TopicController@index')->name('admin.topics.index');
            Route::get('topics/create', 'TopicController@create')->name('admin.topics.create');
            Route::post('topics', 'TopicController@store')->name('admin.topics.store');
            Route::get('topics/{topic}/edit', 'TopicController@edit')->name('admin.topics.edit');
            Route::patch('topics/{topic}', 'TopicController@update')->name('admin.topics.update');
            Route::post('topics/{topic}/sync', 'TopicController@sync')->name('admin.topics.firestore.sync');
        });

        /**
         * Users
         */
        Route::middleware('role:' . Roles::admin)->group(function() {
            Route::get('users', 'UserController@index')->name('admin.users.index');
            Route::get('users/create', 'UserController@create')->name('admin.users.create');
            Route::post('users', 'UserController@store')->name('admin.users.store');
            Route::get('users/{user}', 'UserController@show')->name('admin.users.show');
            Route::patch('users/{user}/roles/{role}/assign', 'UserController@assignRole')->name('admin.users.roles.assign');
            Route::patch('users/{user}/roles/{role}/remove', 'UserController@removeRole')->name('admin.users.roles.remove');
        });

        /**
         * Jobs
         */
        Route::get('jobs/{jobStatus}/status', 'JobController@status')->name('admin.jobs.status');
    });
