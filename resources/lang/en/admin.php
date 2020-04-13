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

    'menu' => [
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
    ],

    'pagination' => [
        'previous' => 'Previous',
        'next' => 'Next'
    ]
];
