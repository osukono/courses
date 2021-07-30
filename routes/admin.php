<?php

use App\Library\Permissions;
use App\Library\Roles;

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {

    Route::middleware(['auth', 'permission:' . Permissions::view_admin_panel])
        ->namespace('Admin')->prefix('console')->group(function () {

            Route::get('/', 'AdminController@dashboard')
                ->name('admin.dashboard');

            /**
             * PodcastController
             */
            Route::middleware('permission:' . Permissions::create_podcasts)->group(function () {

            });
            Route::middleware('permission:' . Permissions::view_podcasts)->group(function () {
               Route::get('dev/podcasts', 'PodcastController@index')
                   ->name('admin.dev.podcasts.index');
            });

            /**
             * ContentController
             */
            Route::middleware('permission:' . Permissions::create_content)->group(function () {
                Route::get('dev/courses/create', 'ContentController@create')
                    ->name('admin.dev.courses.create');

                Route::post('dev/courses', 'ContentController@store')
                    ->name('admin.dev.courses.store');
            });
            Route::middleware('permission:' . Permissions::update_content)->group(function () {
                Route::get('dev/courses/{content}/edit', 'ContentController@edit')
                    ->name('admin.dev.courses.edit');

                Route::patch('dev/courses/{content}', 'ContentController@update')
                    ->name('admin.dev.courses.update');
            });
            Route::middleware('permission:' . Permissions::restore_content)->group(function () {
                Route::get('dev/courses/trash', 'ContentController@trash')
                    ->name('admin.dev.courses.trash');

                Route::post('dev/courses/restore', 'ContentController@restore')
                    ->name('admin.dev.courses.restore');
            });
            Route::middleware('permission:' . Permissions::view_content)->group(function () {
                Route::get('dev/courses', 'ContentController@index')
                    ->name('admin.dev.courses.index');

                Route::get('dev/courses/{content}', 'ContentController@show')
                    ->name('admin.dev.courses.show');

                Route::get('dev/courses/{content}/log', 'ContentController@log')
                    ->name('admin.dev.courses.log');

                Route::get('dev/courses/{content}/export', 'ContentController@exportText')
                    ->name('admin.dev.courses..export');

                Route::get('dev/courses/{content}/export/json', 'ContentController@exportJson')
                    ->name('admin.dev.courses.export.json');

                Route::post('dev/courses/{content}/import/json', 'ContentController@importJson')
                    ->name('admin.dev.courses.import.json');
            });
            Route::middleware('permission:' . Permissions::delete_content)->group(function () {
                Route::delete('dev/courses/{content}', 'ContentController@destroy')
                    ->name('admin.dev.courses.destroy');
            });
            Route::middleware('permission:' . Permissions::assign_editors)->group(function () {
                Route::get('dev/courses/{content}/editors', 'ContentController@editors')
                    ->name('admin.dev.courses.editors.index');

                Route::patch('dev/courses/{content}/editors/assign', 'ContentController@assignEditor')
                    ->name('admin.dev.courses.editors.assign');

                Route::patch('dev/courses/{content}/editors/remove', 'ContentController@removeEditor')
                    ->name('admin.dev.courses.editors.remove');
            });

            /**
             * LessonController
             */
            Route::middleware('permission:' . Permissions::view_content)->group(function () {
                Route::get('dev/courses/lessons/{lesson}', 'LessonController@show')
                    ->name('admin.dev.lessons.show');

                Route::get('dev/courses/lessons/{lesson}/log', 'LessonController@log')
                    ->name('admin.dev.lessons.log');
            });
            Route::middleware('permission:' . Permissions::update_content)->group(function () {
                Route::get('dev/courses/{content}/lessons/create', 'LessonController@create')
                    ->name('admin.dev.lessons.create');

                Route::post('dev/courses/{content}/lessons', 'LessonController@store')
                    ->name('admin.dev.lessons.store');

                Route::get('dev/courses/lessons/{lesson}/edit', 'LessonController@edit')
                    ->name('admin.dev.lessons.edit');

                Route::patch('dev/courses/lessons/{lesson}', 'LessonController@update')
                    ->name('admin.dev.lessons.update');

                Route::get('dev/courses/lessons/{lesson}/grammar/edit', 'LessonController@editGrammarPoint')
                    ->name('admin.dev.lessons.grammar.edit');

                Route::patch('dev/courses/lessons/{lesson}/grammar', 'LessonController@updateGrammarPoint')
                    ->name('admin.dev.lessons.grammar.update');

                Route::get('dev/courses/lessons/{lesson}/description/edit', 'LessonController@editDescription')
                    ->name('admin.dev.lessons.description.edit');

                Route::patch('dev/courses/lessons/{lesson}/description', 'LessonController@updateDescription')
                    ->name('admin.dev.lessons.description.update');

                Route::patch('dev/courses/lessons/move', 'LessonController@move')
                    ->name('admin.dev.lessons.move');

                Route::delete('dev/courses/lessons/{lesson}', 'LessonController@destroy')
                    ->name('admin.dev.lessons.destroy');

                Route::get('dev/courses/{content}/lessons/trash', 'LessonController@trash')
                    ->name('admin.dev.lessons.trash');

                Route::post('dev/courses/lessons/restore', 'LessonController@restore')
                    ->name('admin.dev.lessons.restore');

                Route::patch('dev/courses/lessons/{lesson}/disable', 'LessonController@disable')
                    ->name('admin.dev.lessons.disable');

                Route::patch('dev/courses/lessons/{lesson}/enable', 'LessonController@enable')
                    ->name('admin.dev.lessons.enable');

                Route::patch('dev/courses/lessons/{lesson}/language/{language}/image/upload', 'LessonController@uploadImage')
                    ->name('admin.dev.lessons.image.upload');

                Route::delete('dev/courses/lessons/{lesson}/language/{language}/image/delete', 'LessonController@deleteImage')
                    ->name('admin.dev.lessons.image.delete');
            });

            /**
             * ExerciseController
             */
            Route::middleware('permission:' . Permissions::view_content)->group(function () {
                Route::get('dev/courses/exercises/{exercise}', 'ExerciseController@show')
                    ->name('admin.dev.exercises.show');

                Route::get('dev/courses/exercises/{exercise}/log', 'ExerciseController@log')
                    ->name('admin.dev.exercises.log');
            });
            Route::middleware('permission:' . Permissions::update_content)->group(function () {
                Route::post('dev/courses/lessons/{lesson}/exercises', 'ExerciseController@store')
                    ->name('admin.dev.exercises.store');

                Route::patch('dev/courses/exercises/move', 'ExerciseController@move')
                    ->name('admin.dev.exercises.move');

                Route::delete('dev/courses/exercises/{exercise}', 'ExerciseController@destroy')
                    ->name('admin.dev.exercises.destroy');

                Route::get('dev/courses/lessons/{lesson}/exercises/trash', 'ExerciseController@trash')
                    ->name('admin.dev.exercises.trash');

                Route::post('dev/courses/exercises/restore', 'ExerciseController@restore')
                    ->name('admin.dev.exercises.restore');

                Route::patch('dev/courses/exercises/{exercise}/disable', 'ExerciseController@disable')
                    ->name('admin.dev.exercises.disable');

                Route::patch('dev/courses/exercises/{exercise}/enable', 'ExerciseController@enable')
                    ->name('admin.dev.exercises.enable');
            });

            /**
             * ExerciseDataController
             */
            Route::middleware('permission:' . Permissions::update_content)->group(function () {
                Route::post('dev/courses/exercises/{exercise}/data/create', 'ExerciseDataController@store')
                    ->name('admin.dev.exercise.data.create');

                Route::patch('dev/courses/exercise/data/{exerciseData}', 'ExerciseDataController@update')
                    ->name('admin.dev.exercise.data.update');

                Route::patch('dev/courses/exercise/data/{exerciseData}/audio/synthesize', 'ExerciseDataController@synthesizeAudio')
                    ->name('admin.dev.exercise.data.audio.synthesize');

                Route::patch('dev/courses/exercise/data/{exerciseData}/audio/delete', 'ExerciseDataController@deleteAudio')
                    ->name('admin.dev.exercise.data.audio.delete');

                Route::patch('dev/courses/exercise/data/move', 'ExerciseDataController@move')
                    ->name('admin.dev.exercise.data.move');

                Route::delete('dev/courses/exercise/data/{exerciseData}', 'ExerciseDataController@destroy')
                    ->name('admin.dev.exercise.data.destroy');

                Route::get('dev/courses/exercises/{exercise}/data/trash', 'ExerciseDataController@trash')
                    ->name('admin.dev.exercise.data.trash');

                Route::post('dev/courses/exercise/data/restore', 'ExerciseDataController@restore')
                    ->name('admin.dev.exercise.data.restore');

                Route::patch('dev/courses/exercise/data/{exerciseData/disable/{language}', 'ExerciseDataController@disable')
                    ->name('admin.dev.exercise.data.disable');

                Route::patch('dev/courses/exercise/data/{exerciseData/enable/{language}', 'ExerciseDataController@enable')
                    ->name('admin.dev.exercise.data.enable');
            });

            /**
             * TranslationController
             */
            Route::middleware('permission:' . Permissions::view_translations)->group(function () {
                Route::get('dev/courses/trans/{language}/{content}', 'TranslationController@showContent')
                    ->name('admin.translations.show');

                Route::get('dev/courses/trans/{language}/lessons/{lesson}', 'TranslationController@showLesson')
                    ->name('admin.translations.lessons.show');

                Route::get('dev/courses/trans/{language}/exercises/{exercise}', 'TranslationController@showExercise')
                    ->name('admin.translations.exercises.show');

                Route::get('dev/courses/trans/{language}/content/{content}/export', 'TranslationController@export')
                    ->name('admin.translations.export');
            });
            Route::middleware('permission:' . Permissions::update_translations)->group(function () {
                Route::get('dev/courses/trans/{language}/lessons/{lesson}/grammar/edit', 'TranslationController@editGrammarPoint')
                    ->name('admin.translations.lesson.grammar.edit');

                Route::patch('dev/courses/trans/{language}/lessons/{lesson}/grammar', 'TranslationController@updateGrammarPoint')
                    ->name('admin.translations.lesson.grammar.update');

                Route::get('dev/courses/trans/{language}/lessons/{lesson}/description/edit', 'TranslationController@editDescription')
                    ->name('admin.translations.lesson.description.edit');

                Route::patch('dev/courses/trans/{language}/lessons/{lesson}/description', 'TranslationController@updateDescription')
                    ->name('admin.translations.lesson.description.update');

                Route::patch('dev/courses/trans/{translation}', 'TranslationController@update')
                    ->name('admin.translations.exercise.data.update');

                Route::patch('dev/courses/trans/{translation}/audio/synthesize', 'TranslationController@synthesizeAudio')
                    ->name('admin.translations.audio.synthesize');

                Route::patch('dev/courses/trans/{translation}/audio/delete', 'TranslationController@deleteAudio')
                    ->name('admin.translations.audio.delete');

                Route::patch('dev/courses/trans/{language}/lessons/{lesson}/disable', 'TranslationController@disableLesson')
                    ->name('admin.translations.lessons.disable');

                Route::patch('dev/courses/trans/{language}/lessons/{lesson}/enable', 'TranslationController@enableLesson')
                    ->name('admin.translations.lessons.enable');

                Route::patch('dev/courses/trans/{language}/exercises/{exercise}/disable', 'TranslationController@disableExercise')
                    ->name('admin.translations.exercises.disable');

                Route::patch('dev/courses/trans/{language}/exercises/{exercise}/enable', 'TranslationController@enableExercise')
                    ->name('admin.translations.exercises.enable');
            });
            Route::middleware('permission:' . Permissions::assign_editors)->group(function () {
                Route::get('dev/courses/trans/{language}/content/{content}/editors', 'TranslationController@editors')
                    ->name('admin.translations.editors.index');

                Route::patch('dev/courses/trans/{language}/editors/assign', 'TranslationController@assignEditor')
                    ->name('admin.translations.editors.assign');

                Route::patch('dev/courses/trans/{language}/editors/remove', 'TranslationController@removeEditor')
                    ->name('admin.translations.editors.remove');
            });
            Route::middleware('permission:' . Permissions::publish_courses)->group(function () {
                Route::post('dev/courses/trans/{language}/content/{content}/commit', 'TranslationController@commit')
                    ->name('admin.translations.commit');
            });

            /**
             * PractiseController
             */
            Route::middleware('permission:' . Permissions::view_translations)->group(function () {
                Route::get('practise/translations/{language}/lessons/{lesson}/listening', 'PractiseController@listening')
                    ->name('admin.practise.listening');

                Route::get('practise/translations/{language}/lessons/{lesson}/speaking', 'PractiseController@speaking')
                    ->name('admin.practise.speaking');
            });

            /**
             * Courses
             */
            Route::middleware('permission:' . Permissions::view_courses)->group(function () {
                Route::get('prod', 'CourseController@index')
                    ->name('admin.courses.index');

                Route::get('prod/{course}', 'CourseController@show')
                    ->name('admin.courses.show');

                Route::get('prod/{course}/practice/lessons/{courseLesson}', 'CourseController@practice')
                    ->name('admin.courses.practice');
            });
            Route::middleware('permission:' . Permissions::publish_courses)->group(function () {
                Route::post('prod/{course}/firestore/upload', 'CourseController@firestoreUpload')
                    ->name('admin.courses.firestore.upload');

                Route::post('prod/{course}/firestore/update', 'CourseController@firestoreUpdate')
                    ->name('admin.courses.firestore.update');

                Route::delete('prod/{course}/delete', 'CourseController@delete')
                    ->name('admin.courses.delete');

                Route::post('prod/{course}/image/upload', 'CourseController@uploadImage')
                    ->name('admin.courses.image.upload');

                Route::post('prod/{course}/updating/switch', 'CourseController@switchIsUpdating')
                    ->name("admin.courses.updating.switch");
            });
            Route::middleware('permission:' . Permissions::update_courses)->group(function () {
                Route::get('prod/{course}/edit', 'CourseController@edit')
                    ->name('admin.courses.edit');

                Route::patch('prod/{course}', 'CourseController@update')
                    ->name('admin.courses.update');
            });

            /**
             * Languages
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('languages', 'LanguageController@index')
                    ->name('admin.languages.index');

                Route::get('languages/create', 'LanguageController@create')
                    ->name('admin.languages.create');

                Route::post('languages', 'LanguageController@store')
                    ->name('admin.languages.store');

                Route::get('languages/{language}/edit', 'LanguageController@edit')
                    ->name('admin.languages.edit');

                Route::patch('languages/{language}', 'LanguageController@update')
                    ->name('admin.languages.update');

                Route::post('languages/{language}/icon/upload', 'LanguageController@uploadIcon')
                    ->name('admin.languages.icon.upload');

                Route::post('languages/{language}/sync', 'LanguageController@sync')
                    ->name('admin.languages.firestore.sync');
            });

            /**
             * App Locales
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('app/locales', 'AppLocaleController@index')
                    ->name('admin.app.locales.index');

                Route::post('app/locales/download', 'AppLocaleController@download')
                    ->name('admin.app.locales.download');

                Route::post('app/locales/upload', 'AppLocaleController@upload')
                    ->name('admin.app.locales.upload');

                Route::get('app/locales/create', 'AppLocaleController@create')
                    ->name('admin.app.locales.create');

                Route::post('app/locales', 'AppLocaleController@store')
                    ->name('admin.app.locales.store');

                Route::get('app/locales/{appLocale}/edit', 'AppLocaleController@edit')
                    ->name('admin.app.locales.edit');

                Route::patch('app/locales/{appLocale}', 'AppLocaleController@update')
                    ->name('admin.app.locales.update');

                Route::delete('app/locales/{appLocale}', 'AppLocaleController@delete')
                    ->name('admin.app.locales.delete');


                Route::get('app/locale/groups', 'LocaleGroupController@index')
                    ->name('admin.app.locale.groups.index');

                Route::get('app/locale/groups/create', 'LocaleGroupController@create')
                    ->name('admin.app.locale.groups.create');

                Route::post('app/locale/groups/store', 'LocaleGroupController@store')
                    ->name('admin.app.locale.groups.store');

                Route::get('app/locale/groups/{localeGroup}/edit', 'LocaleGroupController@edit')
                    ->name('admin.app.locale.groups.edit');

                Route::patch('app/locale/groups/{localeGroup}', 'LocaleGroupController@update')
                    ->name('admin.app.locale.groups.update');
            });

            /**
             * Speech Settings
             */
            Route::middleware('permission:' . Permissions::update_content)->group(function () {
                Route::get('content/{content}/speech/settings/edit', 'SpeechSettingsController@editContentSettings')
                    ->name('admin.content.speech.settings.edit');

                Route::post('content/{content}/speech/settings', 'SpeechSettingsController@updateContentSettings')
                    ->name('admin.content.speech.settings.update');
            });
            Route::middleware('permission:' . Permissions::update_translations)->group(function () {
                Route::get('translations/{language}/content/{content}/speech/settings/edit', 'SpeechSettingsController@editTranslationSettings')
                    ->name('admin.translations.speech.settings.edit');

                Route::post('translations/{language}/content/{content}/speech/settings', 'SpeechSettingsController@updateTranslationSettings')
                    ->name('admin.translations.speech.settings.update');
            });

            /**
             * Player Settings
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('languages/{language}/player/settings/create', 'PlayerSettingsController@create')
                    ->name('admin.player.settings.create');

                Route::post('languages/{language}/player/settings', 'PlayerSettingsController@store')
                    ->name('admin.player.settings.store');

                Route::get('languages/{language}/player/settings/edit', 'PlayerSettingsController@edit')
                    ->name('admin.player.settings.edit');

                Route::patch('languages/{language}/player/settings', 'PlayerSettingsController@update')
                    ->name('admin.player.settings.update');
            });

            /**
             * Topics
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('topics', 'TopicController@index')
                    ->name('admin.topics.index');

                Route::get('topics/create', 'TopicController@create')
                    ->name('admin.topics.create');

                Route::post('topics', 'TopicController@store')
                    ->name('admin.topics.store');

                Route::get('topics/{topic}/edit', 'TopicController@edit')
                    ->name('admin.topics.edit');

                Route::patch('topics/{topic}', 'TopicController@update')
                    ->name('admin.topics.update');

                Route::post('topics/{topic}/sync', 'TopicController@sync')
                    ->name('admin.topics.firestore.sync');
            });

            /**
             * Users
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('users', 'UserController@index')
                    ->name('admin.users.index');

                Route::get('users/create', 'UserController@create')
                    ->name('admin.users.create');

                Route::post('users', 'UserController@store')
                    ->name('admin.users.store');

                Route::get('users/{user}', 'UserController@show')
                    ->name('admin.users.show');

                Route::patch('users/{user}/roles/assign', 'UserController@assignRole')
                    ->name('admin.users.roles.assign');

                Route::patch('users/{user}/roles/{role}/remove', 'UserController@removeRole')
                    ->name('admin.users.roles.remove');

                Route::patch('users/{user}/content/access/assign', 'UserController@assignContent')
                    ->name('admin.users.content.access.assign');

                Route::patch('users/{user}/content/{content}/access/remove', 'UserController@removeContent')
                    ->name('admin.users.content.access.remove');

                Route::patch('users/{user}/translations/access/assign', 'UserController@assignTranslation')
                    ->name('admin.users.translations.access.assign');

                Route::patch('users/{user}/translations/{language}/access/remove', 'UserController@removeTranslation')
                    ->name('admin.users.translations.access.remove');
            });

            /**
             * Firebase Users
             */
            Route::middleware('role:' . Roles::admin)->group(function () {
                Route::get('firebase/users', 'FirebaseUserController@index')
                    ->name('admin.firebase.users.index');
            });

            /**
             * Profile
             */
            Route::get('profile', 'ProfileController@index')
                ->name('admin.profile');
            Route::patch('profile/information', 'ProfileController@update')
                ->name('admin.profile.update');
            Route::patch('profile/password', 'ProfileController@updatePassword')
                ->name('admin.profile.password.update');

            /**
             * Jobs
             */
            Route::get('jobs/{jobStatus}/status', 'JobController@status')
                ->name('admin.jobs.status');
        });

});
