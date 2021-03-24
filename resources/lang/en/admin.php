<?php

return [
    'form' => [
        'create' => 'Create',
        'save' => 'Save',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'restore' => 'Restore',
        'custom_file_text' => 'Browse',
        'delete_confirmation' => 'Do you want to delete :object?',
    ],

    'dashboard' => [
        'title' => 'Dashboard',
        'cards' => [
            'users' => [
                'title' => 'Users',
            ],
            'courses' => [
                'title' => 'Courses',
            ],
            'statistics' => [
                'lessons' => [
                    'title' => 'Lessons Learned',
                ],
                'development' => [
                    'title' => 'Development (last month)',
                    'value' => ':num changes'
                ],
            ],
        ],
    ],

    'dev' => [
        'title' => 'Development',
        'courses' => [
            'title' => 'Courses',
            'toolbar' => [
                'create' => 'Create Course',
                'trash' => 'Trash',
            ],
            'list' => [
                'columns' => [
                    'title' => 'Title',
                    'lessons' => 'Lessons',
                    'modified' => 'Last Modified',
                ]
            ],
            'create' => [
                'title' => 'Create Course',
                'fields' => [
                    'language' => 'Language',
                    'level' => 'Level',
                    'topic' => 'Topic',
                    'title' => 'Title',
                ]
            ],
            'trash' => [
                'title' => 'Trash',
            ]
        ],
        'lessons' => [
            'toolbar' => [
                'create' => 'Create Lesson',
                'more' => [
                    'editors' => 'Course Editors',
                    'export' => [
                        'title' => 'Export',
                        'backup' => 'Backup'
                    ],
                    'import' => [
                        'title' => 'Import',
                        'backup' => 'Backup'
                    ],
                    'properties' => [
                        'title' => 'Properties',
                        'course' => 'Course',
                        'speech' => 'Text to Speech',
                    ],
                    'delete' => 'Delete Course',
                    'trash' => 'Trash'
                ],
                'translations' => 'Translation',
            ],
            'trans' => [
                'toolbar' => [
                    'more' => [
                        'editors' => 'Translation Editors',
                        'export' => [
                            'title' => 'Export',
                        ],
                        'properties' => [
                            'title' => 'Properties',
                            'speech' => 'Text to Speech',
                        ],
                        'commit' => 'Commit',
                    ],
                ],
            ],
        ],
    ],

    'production' => [
        'title' => 'Production'
    ],

    'application' => [
        'title' => 'Application'
    ],

    'languages' => [
        'title' => 'Languages',
    ],

    'topics' => [
        'title' => 'Topics',
    ],

    'localizations' => [
        'title' => 'Localization'
    ],

    'users' => [
        'title' => 'Users'
    ],

    'menu' => [
        'console' => [
            'header' => 'Console',
            'dashboard' => 'Dashboard',
            'users' => 'Users'
        ],
        'courses' => [
            'header' => 'Courses',
            'development' => 'Development',
            'production' => 'Production',
        ],
        'app' => [
            'header' => 'App Settings',
            'languages' => 'Languages',
            'topics' => 'Course Topics',
            'localization' => 'Localizations'
        ],


        'properties' => 'Properties',
        'log' => 'Changelog',
        'create' => [
            'content' => 'Create Content',
            'lesson' => 'Create Lesson',
            'exercise' => 'Create Exercise',
            'language' => 'Create Language',
        ],
        'trash' => 'Trash',
        'editors' => 'Editors',
        'download' => 'Download',
    ],

    'messages' => [
        'created' => ':object created.',
        'deleted' => [
            'success' => ':object deleted.',
            'failure' => ':object cannot be deleted.',
        ],
        'trashed' => [
            'success' => ':object moved to trash.',
            'already_trashed' => ':object is already trashed.',
        ],
        'restored' => [
            'success' => ':object restored.',
            'is_not_trashed' => ':object is not trashed.',
        ],
        'disabled' => ':object disabled.',
        'enabled' => ':object enabled.',
        'translations' => [
            'disabled' => ':object translation disabled.',
            'enabled' => ':object translation enabled'
        ],
        'editors' => [
            'assigned' => ":subject assigned to :object' editors.",
            'removed' => ":subject removed from :object' editors.",
        ],
        'audio' => [
            'synthesized' => 'The audio has successfully been synthesized.',
        ],
    ],

    'pagination' => [
        'previous' => 'Previous',
        'next' => 'Next',
    ],
];
