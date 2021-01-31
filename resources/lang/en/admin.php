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
                    'title' => 'Development Activity (last month)',
                    'value' => ':num changes'
                ],
            ],
        ],
    ],

    'development' => [
        'title' => 'Development',
        'subtitle' => 'Content',
        'content' => [
            'title' => 'Content',
            'toolbar' => [
                'create' => 'Create Content',
                'trash' => 'Trash'
            ]
        ]
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
        'dashboard' => 'Dashboard',
        'courses' => [
            'header' => 'Courses',
            'development' => 'Development',
            'production' => 'Production',
        ],
        'app' => [
            'header' => 'Application',
            'languages' => 'Languages',
            'topics' => 'Topics',
            'localization' => 'Localization'
        ],
        'console' => [
            'header' => 'Console',
            'users' => 'Users'
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
        'next' => 'Next'
    ]
];
