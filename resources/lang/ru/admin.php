<?php

return [
    'form' => [
        'create' => 'Создать',
        'save' => 'Сохранить',
        'delete' => 'Удалить',
        'cancel' => 'Отмена',
        'restore' => 'Восстановить',
        'custom_file_text' => 'Обзор',
        'delete_confirmation' => 'Вы хотите удалить :object?',
    ],

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

    'dev' => [
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
                    'lessons' => 'Уроки',
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
        ],
        'lessons' => [
            'toolbar' => [
                'create' => 'Добавить урок',
                'more' => [
                    'editors' => 'Редакторы курса',
                    'export' => [
                        'title' => 'Экспорт',
                        'backup' => 'Резервная копия'
                    ],
                    'import' => [
                        'title' => 'Импорт',
                        'backup' => 'Резервная копия'
                    ],
                    'properties' => [
                        'title' => 'Свойства',
                        'course' => 'Курс',
                        'speech' => 'Синтезатор',
                    ],
                    'delete' => 'Удалить курс',
                    'trash' => 'Корзина'
                ],
                'translations' => 'Перевод'
            ],
            'trans' => [
                'toolbar' => [
                    'more' => [
                        'editors' => 'Редакторы перевода',
                        'export' => [
                            'title' => 'Экспорт',
                        ],
                        'properties' => [
                            'title' => 'Свойства',
                            'speech' => 'Синтезатор',
                        ],
                        'commit' => 'Опубликовать',
                    ],
                ],
            ],
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
