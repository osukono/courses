<?php

return [
    'menu' => [
        'console' => [
            'header' => 'Консоль',
            'dashboard' => 'Статистика',
            'users' => 'Пользователи'
        ],
        'courses' => [
            'header' => 'Курсы',
            'development' => 'В разработке',
            'production' => 'Опубликованные',
        ],
        'app' => [
            'header' => 'Настройки приложения',
            'languages' => 'Языки',
            'topics' => 'Темы курсов',
            'localization' => 'Локализации'
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
