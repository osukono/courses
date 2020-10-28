<?php

use App\AppLocale;
use App\Content;
use App\Course;
use App\CourseLesson;
use App\Exercise;
use App\Language;
use App\Lesson;
use App\LocaleGroup;
use App\Topic;
use App\User;


// Dashboard
Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Content
 * ---------------------------------------------------------------------------------------------------------------------
 */

// Content
Breadcrumbs::for('admin.content.index', function ($trail) {
    $trail->push('Development', route('admin.content.index'));
});

// Content > Create
Breadcrumbs::for('admin.content.create', function ($trail) {
    $trail->parent('admin.content.index');
    $trail->push('Create');
});

// Content > Trash
Breadcrumbs::for('admin.content.trash', function ($trail) {
    $trail->parent('admin.content.index');
    $trail->push('Trash');
});

// [Content]
Breadcrumbs::for('admin.content.show', function ($trail, Content $content) {
    $trail->push($content, route('admin.content.show', $content));
});

// [Content] > Properties
Breadcrumbs::for('admin.content.edit', function ($trail, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Properties');
});

// [Content] > Content Editors
Breadcrumbs::for('admin.content.editors', function ($trail, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Content Editors');
});

// [Content] > Speech Settings
Breadcrumbs::for('admin.content.speech.settings', function ($trail, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Speech Settings');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Lessons
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > Create Lesson
Breadcrumbs::for('admin.lessons.create', function ($trail, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Create Lesson');
});

// [Content] > [Lesson]
Breadcrumbs::for('admin.lessons.show', function ($trail, Lesson $lesson) {
    $trail->parent('admin.content.show', $lesson->content);
    $trail->push($lesson->index . '. ' . $lesson->title, route('admin.lessons.show', $lesson));
});

// [Content] > [Lesson] > Properties
Breadcrumbs::for('admin.lessons.edit', function ($trail, Lesson $lesson) {
    $trail->parent('admin.lessons.show', $lesson);
    $trail->push('Properties');
});

// [Content] > Trash
Breadcrumbs::for('admin.lessons.trash', function ($trail, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Trash');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Exercises
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > [Lesson] > [Exercise]
Breadcrumbs::for('admin.exercises.show', function ($trail, Exercise $exercise) {
    $trail->parent('admin.lessons.show', $exercise->lesson);
    $trail->push($exercise->index, route('admin.exercises.show', $exercise));
});

// [Content] > [Lesson] > Trash
Breadcrumbs::for('admin.exercises.trash', function ($trail, Lesson $lesson) {
    $trail->parent('admin.lessons.show', $lesson);
    $trail->push('Trash');
});

// [Content] > [Lesson] > [Exercise] > Trash
Breadcrumbs::for('admin.exercise.data.trash', function ($trail, Exercise $exercise) {
    $trail->parent('admin.exercises.show', $exercise);
    $trail->push('Trash');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Translations
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > [Language]
Breadcrumbs::for('admin.translations.content.show', function ($trail, Language $language, Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push($language, route('admin.translations.content.show', [$language, $content]));
});

// [Content] > [Language] > Translation Editors
Breadcrumbs::for('admin.translations.editors', function ($trail, Language $language, Content $content) {
    $trail->parent('admin.translations.content.show', $language, $content);
    $trail->push('Translation Editors');
});

// [Content] > [Language] > Speech Settings
Breadcrumbs::for('admin.translations.speech.settings', function ($trail, Language $language, Content $content) {
    $trail->parent('admin.translations.content.show', $language, $content);
    $trail->push('Speech Settings');
});

// [Content] > [Language] > [Lesson]
Breadcrumbs::for('admin.translations.lesson.show', function ($trail, Language $language,  Lesson $lesson) {
    $trail->parent('admin.translations.content.show', $language, $lesson->content);
    $trail->push($lesson->index . '. ' . $lesson->title, route('admin.translations.lesson.show', [$language, $lesson]));
});

// [Content] > [Language] > [Lesson] > [Exercise]
Breadcrumbs::for('admin.translations.exercise.show', function ($trail, Language $language, Exercise $exercise) {
    $trail->parent('admin.translations.lesson.show', $language, $exercise->lesson);
    $trail->push($exercise->index, route('admin.translations.exercise.show', [$language, $exercise]));
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Courses
 * ---------------------------------------------------------------------------------------------------------------------
 */

// Courses
Breadcrumbs::for('admin.courses.index', function ($trail) {
    $trail->push('Production', route('admin.courses.index'));
});

// Courses > [Course]
Breadcrumbs::for('admin.courses.show', function ($trail, Course $course) {
    $trail->parent('admin.courses.index');
    $trail->push($course, route('admin.courses.show', $course));
});

// Courses > [Course] > Properties
Breadcrumbs::for('admin.courses.edit', function ($trail, Course $course) {
    $trail->parent('admin.courses.show', $course);
    $trail->push('Properties');
});

// Courses > [Course] > [CourseLesson]
Breadcrumbs::for('admin.courses.practice', function ($trail, Course $course, CourseLesson $courseLesson) {
    $trail->parent('admin.courses.show', $course);
    $trail->push($courseLesson->index . '. ' . $courseLesson);
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Languages
 * ---------------------------------------------------------------------------------------------------------------------
 */

// Languages
Breadcrumbs::for('admin.languages.index', function ($trail) {
    $trail->push('Languages', route('admin.languages.index'));
});

// Languages > Create
Breadcrumbs::for('admin.languages.create', function ($trail) {
    $trail->parent('admin.languages.index');
    $trail->push('Create');
});

// Languages > [Language]
Breadcrumbs::for('admin.languages.show', function ($trail, Language $language) {
    $trail->parent('admin.languages.index');
    $trail->push($language);
});

// Languages > [Language] > Properties
Breadcrumbs::for('admin.languages.edit', function ($trail, Language $language) {
    $trail->parent('admin.languages.show', $language);
    $trail->push('Properties');
});

// Languages > [Language] > Create Player Settings
Breadcrumbs::for('admin.player.settings.create', function ($trail, Language $language) {
    $trail->parent('admin.languages.show', $language);
    $trail->push('Create Player Settings');
});

// Languages > [Languages] > Update Player Settings
Breadcrumbs::for('admin.player.settings.edit', function($trail, Language $language) {
    $trail->parent('admin.languages.show', $language);
    $trail->push('Update Player Settings');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Topics
 * ---------------------------------------------------------------------------------------------------------------------
 */

// Topics
Breadcrumbs::for('admin.topics.index', function ($trail) {
    $trail->push('Topics', route('admin.topics.index'));
});

// Topics > Create
Breadcrumbs::for('admin.topics.create', function ($trail) {
    $trail->parent('admin.topics.index');
    $trail->push('Create');
});

// Topics > [Topic]
Breadcrumbs::for('admin.topics.show', function ($trail, Topic $topic) {
    $trail->parent('admin.topics.index');
    $trail->push($topic);
});

// Topics > [Topic] > Properties
Breadcrumbs::for('admin.topics.edit', function ($trail, Topic $topic) {
    $trail->parent('admin.topics.show', $topic);
    $trail->push('Properties');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * App Localization
 * ---------------------------------------------------------------------------------------------------------------------
 */

// App Localizations
Breadcrumbs::for('admin.app.locales.index', function ($trail) {
    $trail->push('App Localization', route('admin.app.locales.index'));
});

// App Localizations > Create
Breadcrumbs::for('admin.app.locales.create', function ($trail) {
    $trail->parent('admin.app.locales.index');
    $trail->push('Create');
});

// App Localizations > [App Locale]
Breadcrumbs::for('admin.app.locales.show', function ($trail, AppLocale $appLocale) {
    $trail->parent('admin.app.locales.index');
    $trail->push($appLocale);
});

// App Localizations > [App Locale] > Properties
Breadcrumbs::for('admin.app.locales.edit', function ($trail, AppLocale $appLocale) {
    $trail->parent('admin.app.locales.show', $appLocale);
    $trail->push('Properties');
});

// App Localizations > Groups
Breadcrumbs::for('admin.app.locale.groups.index', function ($trail) {
    $trail->parent('admin.app.locales.index');
    $trail->push('Groups', route('admin.app.locale.groups.index'));
});

// App Localizations > Groups > Create
Breadcrumbs::for('admin.app.locale.groups.create', function ($trail) {
    $trail->parent('admin.app.locale.groups.index');
    $trail->push('Create');
});

// App Localizations > Groups > [Group]
Breadcrumbs::for('admin.app.locale.groups.show', function ($trail, LocaleGroup $localeGroup) {
    $trail->parent('admin.app.locale.groups.index');
    $trail->push($localeGroup);
});

// App Localizations > Groups > [Group] > Properties
Breadcrumbs::for('admin.app.locale.groups.edit', function ($trail, LocaleGroup $localeGroup) {
    $trail->parent('admin.app.locale.groups.show', $localeGroup);
    $trail->push('Properties');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Users
 * ---------------------------------------------------------------------------------------------------------------------
 */

// Users
Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->push('Users', route('admin.users.index'));
});

// Users > Create
Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create');
});

// Users > [User]
Breadcrumbs::for('admin.users.show', function ($trail, User $user) {
    $trail->parent('admin.users.index');
    $trail->push($user, route('admin.users.show', $user));
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Profile
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [User]
Breadcrumbs::for('admin.user', function ($trail, User $user) {
    $trail->push($user);
});

// [User] > Profile
Breadcrumbs::for('admin.user.profile', function($trail, User $user) {
    $trail->parent('admin.user', $user);
    $trail->push('Profile');
});
