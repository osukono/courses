<?php

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
    $trail->push('Content', route('admin.content.index'));
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
Breadcrumbs::for('admin.content.show', function ($trail, \App\Content $content) {
    $trail->push($content, route('admin.content.show', $content));
});

// [Content] > Properties
Breadcrumbs::for('admin.content.edit', function ($trail, \App\Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Properties');
});

// [Content] > Content Editors
Breadcrumbs::for('admin.content.editors', function ($trail, \App\Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Content Editors');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Lessons
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > Create Lesson
Breadcrumbs::for('admin.lessons.create', function ($trail, \App\Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Create Lesson');
});

// [Content] > [Lesson]
Breadcrumbs::for('admin.lessons.show', function ($trail, \App\Lesson $lesson) {
    $trail->parent('admin.content.show', $lesson->content);
    $trail->push($lesson, route('admin.lessons.show', $lesson));
});

// [Content] > [Lesson] > Properties
Breadcrumbs::for('admin.lessons.edit', function ($trail, \App\Lesson $lesson) {
    $trail->parent('admin.lessons.show', $lesson);
    $trail->push('Properties');
});

// [Content] > Trash
Breadcrumbs::for('admin.lessons.trash', function ($trail, \App\Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push('Trash');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Exercises
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > [Lesson] > [Exercise]
Breadcrumbs::for('admin.exercises.show', function ($trail, \App\Exercise $exercise) {
    $trail->parent('admin.lessons.show', $exercise->lesson);
    $trail->push($exercise->index, route('admin.exercises.show', $exercise));
});

// [Content] > [Lesson] > Trash
Breadcrumbs::for('admin.exercises.trash', function ($trail, \App\Lesson $lesson) {
    $trail->parent('admin.lessons.show', $lesson);
    $trail->push('Trash');
});

// [Content] > [Lesson] > [Exercise] > Trash
Breadcrumbs::for('admin.exercise.fields.trash', function ($trail, \App\Exercise $exercise) {
    $trail->parent('admin.exercises.show', $exercise);
    $trail->push('Trash');
});

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Translations
 * ---------------------------------------------------------------------------------------------------------------------
 */

// [Content] > [Language]
Breadcrumbs::for('admin.translations.content.show', function ($trail, \App\Language $language, \App\Content $content) {
    $trail->parent('admin.content.show', $content);
    $trail->push($language, route('admin.translations.content.show', [$language, $content]));
});

// [Content] > [Language] > Translation Editors
Breadcrumbs::for('admin.translations.editors', function ($trail, \App\Language $language, \App\Content $content) {
    $trail->parent('admin.translations.content.show', $language, $content);
    $trail->push('Translation Editors');
});

// [Content] > [Language] > [Lesson]
Breadcrumbs::for('admin.translations.lesson.show', function ($trail, \App\Language $language,  \App\Lesson $lesson) {
    $trail->parent('admin.translations.content.show', $language, $lesson->content);
    $trail->push($lesson, route('admin.translations.lesson.show', [$language, $lesson]));
});

// [Content] > [Language] > [Lesson] > [Exercise]
Breadcrumbs::for('admin.translations.exercise.show', function ($trail, \App\Language $language, \App\Exercise $exercise) {
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
    $trail->push('Courses', route('admin.courses.index'));
});

// Courses > [Course]
Breadcrumbs::for('admin.courses.show', function ($trail, \App\Course $course) {
    $trail->parent('admin.courses.index');
    $trail->push($course, route('admin.courses.show', $course));
});

// Courses > [Course] > Properties
Breadcrumbs::for('admin.courses.edit', function ($trail, \App\Course $course) {
    $trail->parent('admin.courses.show', $course);
    $trail->push('Properties');
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
Breadcrumbs::for('admin.languages.show', function ($trail, \App\Language $language) {
    $trail->parent('admin.languages.index');
    $trail->push($language);
});

// Languages > [Language] > Properties
Breadcrumbs::for('admin.languages.edit', function ($trail, \App\Language $language) {
    $trail->parent('admin.languages.show', $language);
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

// Users > [User]
Breadcrumbs::for('admin.users.show', function ($trail, \App\User $user) {
    $trail->parent('admin.users.index');
    $trail->push($user, route('admin.users.show', $user));
});
