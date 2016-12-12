<?php
return [
    'routes' => [
        [
            'name' => 'ytdata',
            'path' => '/ytdata',
            'middleware' => [
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::ytdata',
                    'layout' => 'layout::none',
                ],
            ],
        ],
    ],
];
