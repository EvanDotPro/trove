<?php
use Tv\Auth;
return [
    'dependencies' => [
        'factories' => [
            EvantSource\DomainDispatcher::class => EvantSource\Container\DomainDispatcherFactory::class,
            EvantSource\AggregateRepository::class => EvantSource\Container\AggregateRepositoryFactory::class,
            EvantSource\CqrsMiddleware::class => EvantSource\Container\CqrsMiddlewareFactory::class,
        ],
    ],

    'evantsource' => [
        Tv\Auth\Command\RegisterUser::class => Tv\Auth\Command\RegisterUserHandler::class,
        Tv\Auth\Command\ChangePassword::class => Tv\Auth\Command\ChangePasswordHandler::class,
        Tv\Auth\Query\UsernameAvailable::class => Tv\Auth\Query\UsernameAvailableHandler::class,

        Tv\Auth\Event\UserRegistered::class => [
            Tv\Auth\Listener\UserProjector::class,
        ],
        Tv\Auth\Event\PasswordChanged::class => [
            Tv\Auth\Listener\UserProjector::class,
        ],

        Tv\Channel\Query\FeaturedChannels::class => Tv\Channel\Query\FeaturedChannelsHandler::class,
        Tv\Channel\Query\ChannelPathAvailable::class => Tv\Channel\Query\ChannelPathAvailableHandler::class,
        Tv\Channel\Query\VideoToWatch::class => Tv\Channel\Query\VideoToWatchHandler::class,

        Tv\Channel\Command\CreateChannel::class => Tv\Channel\Command\CreateChannelHandler::class,
        Tv\Channel\Command\AddVideoToChannel::class => Tv\Channel\Command\AddVideoToChannelHandler::class,

        Tv\Channel\Event\VideoAddedToChannel::class => [
            Tv\Channel\Listener\ChannelProjector::class,
        ],
        Tv\Channel\Event\ChannelCreated::class => [
            Tv\Channel\Listener\ChannelProjector::class,
        ],
        Tv\Channel\Event\ChannelFeatured::class => [
            Tv\Channel\Listener\ChannelProjector::class,
        ],
        Tv\Channel\Event\ChannelUnfeatured::class => [
            Tv\Channel\Listener\ChannelProjector::class,
        ],
    ],
];
