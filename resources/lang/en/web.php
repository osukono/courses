<?php

return [
    'header' => [
        'download' => "Download"
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
        'instruction' => "Listen carefully trying to remember translation. After the listening part, you will have an opportunity to practice your speaking skills.",
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
                'text' => "Listen to the audio courses, memorize vocabulary and grammar, learn how to speak English.",
                'button' => 'Learn more'
            ],
            'app' => [
                'header' => 'All courses in one app',
                'screen' => [
                    'library' => 'app_library_en.PNG',
                    'course' => 'app_course_en.PNG',
                    'player' => 'app_player_en.PNG',
                ],
                'description' => "<p>Download the app and get access to the courses developed by the most experienced teachers we can offer.</p>" .
                    "<p>Chose a level of difficulty that is the most appropriate for you and listen to our lessons practicing particular aspects of grammar until you gain confidence.</p>" .
                    "<p>Each lesson starts with the review part built from the previously learned material that helps you keep your knowledge fresh and always ready to serve your needs. Next you will listen to the new material where you can easily obtain grammar with numerous examples of its actual usage. And finally, you will have an opportunity to practice your speaking skills.</p>" .
                    "<p>The application built as a player in mind. You can either follow the material you are listening to or just use it as an audio player learning new languages while driving, doing sports and more.</p>",
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
                'text' => "Start learning :course course for FREE",
                'button' => "Get started"
            ],
            'courses' => [
                'header' => "Start from the level that is right for you",
                'more' => "More",
                'less' => 'Less',
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
            'text' => "The requested operation is forbidden and cannot be completed.",
            "button" => "Go home"
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
