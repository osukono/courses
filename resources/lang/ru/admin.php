<?php

return [
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
        'title' => 'Готовые к продаже'
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
        'title' => 'Локализации'
    ],

    'users' => [
        'title' => 'Пользователи'
    ],
];
