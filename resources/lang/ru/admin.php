<?php

return [
    'menu' => [
        'dashboard' => 'Статистика',
        'courses' => [
            'header' => 'Курсы',
            'development' => 'В разработке',
            'production' => 'Опубликованные',
        ],
        'app' => [
            'header' => 'Приложение',
            'languages' => 'Языки',
            'topics' => 'Темы',
            'localization' => 'Локализация'
        ],
        'console' => [
            'header' => 'Консоль',
            'users' => 'Пользователи'
        ],
    ],

    'dashboard' => [
        'title' => 'Статистика',
        'cards' => [
            'users' => [
                'title' => 'Пользователей',
            ],
            'courses' => [
                'title' => 'Курсов',
            ],
            'statistics' => [
                'lessons' => [
                    'title' => 'Пройденных уроков',
                ],
                'development' => [
                    'title' => 'Разработка (последний месяц)',
                    'value' => ':num изменений'
                ],
            ],
        ],
    ],

    'development' => [
        'title' => 'В разработке'
    ],

    'production' => [
        'title' => 'В продаже'
    ],

    'application' => [
        'title' => 'Приложение'
    ],

    'languages' => [
        'title' => 'Языки'
    ],

    'topics' => [
        'title' => 'Темы'
    ],

    'localizations' => [
        'title' => 'Локализация'
    ],

    'users' => [
        'title' => 'Пользователи'
    ],
];
