<?php

return [
    'header' => [
        'download' => "Download",
        'console' => "Course Development",
        'teachers' => "For teachers",
        'logout' => "Log Out",
    ],
    'footer' => [
        'copyright' => "Yummy Lingo © :year. All rights reserved.",
        'privacy' => "Privacy Policy",
        'contact_us' => "Contact us",
        'social' => [
            'title' => 'Follow us on',
            'instagram' => 'Follow us on Instagram',
            'telegram' => 'Learn more on Telegram'
        ],
        'download' => "Download Yummy Lingo"
    ],
    'player' => [
        'instruction' => "",
        'speed' => [
            'slower' => "Slower",
            'normal' => "Normal",
            'faster' => "Faster",
        ]
    ],
    'index' => [
        'seo' => [
            'title' => "Learn English with Yummy Lingo",
            'keywords' => "Yummy Lingo, English with mobile application, English online, English learning, English lessons, learn English, practice English, speak English, English course, Elementary English, Pre-Intermediate English, English for beginners, English for students, English for adults",
            'description' => "English speaking courses. Practice your speaking skills with Yummy Lingo's mobile application."
        ],
        'section' => [
            'top' => [
                'header' => "English lessons in your pocket",
                'text' => "Listen to the audio courses, memorize grammar and vocabulary, learn how to speak English.",
                'button' => 'Learn more'
            ],
            'app' => [
                'header' => 'All courses in one app',
                'screen' => [
                    'library' => 'app_library_en.PNG',
                    'course' => 'app_course_en.PNG',
                    'player' => 'app_player_en.PNG',
                ],
                'description' => "<p>Download the app and get access to the audio courses developed by a team of experienced English teachers. Our teachers have international certificates that confirm their knowledge of English at the level of native speakers.</p>" .
                    "<p>Each lesson covers a separate topic with basic grammatical constructions and vocabulary. Studying regularly with the app, you will gradually learn how to structure English sentences. Over time, these skills will develop to a point until you will no longer need to think before responding to a question or maintaining a conversation in English.</p>" .
                    "<p>The application is developed as an extended player with extra functions. You can either listen to the lessons while driving, committing by transport, doing your home chores, or follow subtitles displayed on your mobile phone.</p>" .
                    "<p>We wish you a productive and successful learning experience with Yummy Lingo.</p>",
                'links' => [
                    'android' => "https://play.google.com/store/apps/details?id=com.yummylingo.app",
                    'ios' => "https://itunes.apple.com/app/apple-store/id1503356144"
                ],
                'badges' => [
                    'google_play' => [
                        'image' => 'google-play-badge_en.png',
                        'alt' => 'Get it on Google Play'
                    ],
                    'app_store' => [
                        'image' => 'Download_on_the_App_Store_Badge_US-UK.svg',
                        'alt' => 'Download on the App Store'
                    ]
                ]
            ],
            'promo' => [
                'text' => ":number students already learn English with Yummy Lingo",
                'button' => "Join"
            ],
            'courses' => [
                'header' => "Start from level that is right for you",
                'more' => "Read more",
                'less' => 'Collapse',
                'demo' => "Demo",
                'lessons' => "Topics"
            ]
        ],
    ],
    'privacy' => [
        'seo' => [
            'title' => "Yummy Lingo - Privacy Policy",
            'keywords' => "Yummy Lingo, Privacy Policy",
            'description' => "Yummy Lingo's Privacy Policy"
        ]
    ],
    'errors' => [
        '401' => [
            'title' => "Unauthorized (401)",
            'text' => "You are not authorized to make this request.",
            'button' => "Go home"
        ],
        '403' => [
            'title' => "Forbidden (403)",
            'text' => "The requested operation is forbidden and cannot be completed. In order to get access, please contact us at support@yummylingo.com",
            "button" => "Home page"
        ],
        '404' => [
            'title' => "Not found (404)",
            'text' => "Sorry, the page you are looking for does not exist.",
            'button' => "Go home"
        ],
        '500' => [
            'title' => "Internal server error (500)",
            'text' => "Something went wrong. We are already working on it. Please try again later.",
            'button' => "Go home"
        ]
    ],
];
