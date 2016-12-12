<?php
use Zend\Expressive\Router;

return [
    'dependencies' => [
        'invokables' => [
            Router\RouterInterface::class => Router\FastRouteRouter::class,
        ],
        'factories' => [
            Tv\Channel\Controller::class => Tv\Channel\ControllerFactory::class,
        ],
    ],
    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => Tv\App\Middleware\StaticView::class,
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'page::home',
                ],
            ],
        ],
        [
            'name' => 'channel/list',
            'path' => '/channels',
            'middleware' => [
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'cqrs_target' => Tv\Channel\Query\FeaturedChannels::class,
                    'view_key' => 'channels',
                    'view' => 'channel::list',
                ],
            ],
        ],
        [
            'name' => 'channel-create-form',
            'path' => '/channels/create',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::create',
                ],
            ],
        ],
        [
            'name' => 'channel-create',
            'path' => '/channels/create',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\App\Middleware\CqrsPayloadFromPost::class,
                Tv\App\Middleware\ValidateCqrsPayload::class,
                Tv\App\Middleware\GenerateNewUuid::class,
                Tv\Auth\Middleware\PopulateCurrentUserId::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\Redirect::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'defaults' => [
                    'input_validator' => Tv\Channel\Validator\CreateChannel::class,
                    'cqrs_target' => Tv\Channel\Command\CreateChannel::class,
                    'new_uuid_field' => 'channelId',
                    'redirect_route' => 'channel',
                    // set the route param 'channel' (of the channel route) to the 'path' post param value
                    'redirect_params' => 'channel:path',
                ],
            ],
        ],
        [
            'name' => 'channel-path-available',
            'path' => '/channels/check',
            'middleware' => [
                Tv\App\Middleware\CqrsPayloadFromQuery::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\ReturnJsonResponse::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'cqrs_target' => Tv\Channel\Query\ChannelPathAvailable::class
                ],
            ],
        ],
        [
            'name' => 'channel-next-video',
            'path' => '/c/{channel:[^/]+}/next',
            'middleware' => [
                Tv\App\Middleware\CqrsPayloadFromQuery::class,
                Tv\Auth\Middleware\PopulateCurrentUserId::class,
                Tv\Channel\Middleware\PopulateChannelIdFromPath::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
                Tv\App\Middleware\ReturnJsonResponse::class,

            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'cqrs_target' => Tv\Channel\Query\VideoToWatch::class
                ],
            ],

        ],
        [
            'name' => 'channel-add-video-form',
            'path' => '/c/{channel:[^/]+}/add',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::add-video',
                ],
            ],
        ],
        [
            'name' => 'channel-add-video',
            'path' => '/c/{channel:[^/]+}/add',
            'middleware' => [
                Tv\Auth\Middleware\AssertIsAuthenticated::class,
                Tv\App\Middleware\ValidateCsrf::class,
                Tv\App\Middleware\CqrsPayloadFromPost::class,
                //Tv\App\Middleware\ValidateCqrsPayload::class,
                Tv\App\Middleware\GenerateNewUuid::class,
                Tv\Auth\Middleware\PopulateCurrentUserId::class,
                Tv\Channel\Middleware\PopulateChannelIdFromPath::class,
                Tv\App\Middleware\DispatchCqrsRequest::class,
            ],
            'allowed_methods' => ['POST'],
            'options' => [
                'defaults' => [
                    'new_uuid_field' => 'videoId',
                    'cqrs_target' => Tv\Channel\Command\AddVideoToChannel::class,
                ],
            ],
        ],
        [
            'name' => 'channel-manage',
            'path' => '/c/{channel:[^/]+}/manage',
            'middleware' => [
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::manage',
                ],
            ],
        ],
        [
            'name' => 'cast',
            'path' => '/cast',
            'middleware' => [
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::cast',
                    'layout' => 'layout::none',
                ],
            ],
        ],
        [
            'name' => 'channel',
            'path' => '/c/{channel:[^/]+}',
            'middleware' => [
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::index',
                ],
            ],
        ],
        [
            'name' => 'channel/videoid',
            'path' => '/c/{channel:[^/]+}/{video:[^/]+}',
            'middleware' => [
                Tv\App\Middleware\StaticView::class,
            ],
            'allowed_methods' => ['GET'],
            'options' => [
                'defaults' => [
                    'view' => 'channel::index',
                ],
            ],
        ],
        [
            'name' => 'channel/submit',
            'path' => '/c/{channel:[^/]+}/submit',
            'middleware' => Tv\Channel\Controller::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
    ],
];
