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
            'development' => 'Разработка',
            'production' => 'Опубликованные',
        ],
        'app' => [
            'header' => 'Приложение',
            'languages' => 'Языки',
            'topics' => 'Темы курсов',
            'localization' => 'Локализация'
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
        'title' => 'Разработка',
        'courses' => [
            'title' => 'Курсы',
            'toolbar' => [
                'create' => 'Добавить курс',
                'trash' => 'Корзина'
            ],
            'list' => [
                'columns' => [
                    'title' => 'Название',
                    'lessons' => 'Уроков',
                    'modified' => 'Изменен'
                ]
            ],
            'create' => [
                'title' => 'Добавление курса',
                'fields' => [
                    'language' => 'Язык',
                    'level' => 'Уровень',
                    'topic' => 'Тема',
                    'title' => 'Название'
                ]
            ],
            'trash' => [
                'title' => 'Корзина'
            ]
        ]
    ],

    'production' => [
        'title' => 'Опубликованные'
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
