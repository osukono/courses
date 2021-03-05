<?php

return [
    'header' => [
        'download' => "Загрузить",
        'console' => "Разработка курсов",
        'teachers' => "Учителям",
        'logout' => "Выйти",
    ],
    'footer' => [
        'copyright' => "Yummy Lingo © :year. Все права защищены.",
        'privacy' => "Конфиденциальность",
        'contact_us' => "Свяжитесь с нами",
        'social' => [
            'title' => 'Подпишитесь на нас',
            'instagram' => 'Следите за нами в Instagram',
            'telegram' => 'Следите за новостями на Telegram'
        ],
        'download' => 'Загрузить Yummy Lingo'
    ],
    'player' => [
        'instruction' => "Слушайте внимательно пытаясь запомнить перевод. После прослушивания у вас будет возможность попрактиковать разговорную часть.",
        'speed' => [
            'slower' => "Медленнее",
            'normal' => "Нормально",
            'faster' => "Быстрее",
        ]
    ],
    'index' => [
        'seo' => [
            'title' => "Английский с Yummy Lingo",
            'keywords' => "Yummy Lingo, английский с мобильным приложением, английский язык, английский, английский онлайн, грамматика английского языка, английский для взрослых, разговорный английский, английский для начинающих, английский с нуля, уроки английского, английский для студентов",
            'description' => "Мобильное приложение для практики разговорного английского. Изучение английского языка с аудио курсами."
        ],
        'section' => [
            'top' => [
                'header' => 'Уроки английского всегда под рукой',
                'text' => 'Слушайте аудиоуроки, запоминайте лексику и грамматику, учитесь говорить на английском ',
                'button' => 'Узнать больше'
            ],
            'app' => [
                'header' => "Все курсы в одном приложении",
                'screen' => [
                    'library' => 'app_library_ru.PNG',
                    'course' => 'app_course_ru.PNG',
                    'player' => 'app_player_ru.PNG',
                ],
                'description' => "<p>Загрузите приложение и получите доступ к аудиокурсам, которые разрабатывала команда лучших преподавателей английского. Учителя в Yummy Lingo обладают международными сертификатами, подтверждающими владение английским языком на уровне носителя. </p>" .
                    "<p>Каждый урок – отдельная тема, в которой собраны базовые грамматические конструкции и запас лексики. Регулярно занимаясь по приложению, вы постепенно запоминаете принципы построения предложений в английском языке. Со временем эти навыки развиваются до автоматизма, и вам уже не нужно думать, чтобы грамотно ответить на вопрос или поддержать беседу на английском. </p>" .
                    "<p>Приложение разработано как аудио плеер с дополнительными функциями. Вы можете просто слушать уроки английского, находясь за рулем, в транспорте или занимаясь домашними делами. Либо следить за текстом, произносимым диктором, который будет отображаться в виде субтитров на экране вашего смартфона, планшета.</p>" .
                    "<p>Желаем вам плодотворного и успешного обучения с Yummy Lingo!</p>",
                'badges' => [
                    'google_play' => [
                        'image' => 'google-play-badge_ru.png',
                        'alt' => 'Доступно в Google Play'
                    ],
                    'app_store' => [
                        'image' => 'Download_on_the_App_Store_Badge_RU.svg',
                        'alt' => 'Загрузите в App Store'
                    ]
                ]

            ],
            'promo' => [
                'text' => ":number студентов уже изучают английский с Yummy Lingo",
                'button' => "Присоединиться"
            ],
            'courses' => [
                'header' => "Начните с курса подходящего вашему уровню знания языка",
                'more' => "Подробнее",
                'less' => 'Скрыть',
                'demo' => "Демонстрация",
                'lessons' => "Темы изучаемые в курсе"
            ]
        ],
    ],
    'privacy' => [
        'seo' => [
            'title' => "Yummy Lingo - Политика конфиденциальности",
            'keywords' => "Yummy Lingo, Политика конфиденциальности",
            'description' => "Политика конфиденциальности Yummy Lingo"
        ]
    ],
    'errors' => [
        '401' => [
            'title' => "Unauthorized (401)",
            'text' => "Для доступа к запрашиваемому ресурсу требуется аутентификация.",
            'button' => "Домой"
        ],
        '403' => [
            'title' => "Forbidden (403)",
            'text' => "Запрос не может быть выполнен из за ограничений к запрашиваемому ресурсу. Для того, чтобы получить доступ, пожалуйста свяжитесь с нами support@yummylingo.com",
            "button" => "На главную"
        ],
        '404' => [
            'title' => "Not Found (404)",
            'text' => "Извините, но страницы которую вы ищете не существует.",
            'button' => "Домой"
        ],
        '500' => [
            'title' => "Internal Server Error (500)",
            'text' => "Что-то пошло не так. Мы уже работаем над этим. Пожалуйста, попробуйте позже.",
            'button' => "Домой"
        ]
    ],
];
