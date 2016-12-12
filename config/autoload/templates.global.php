<?php

return [
    'dependencies' => [
        'invokables' => [
            'layout' => Zend\View\Model\ViewModel::class,
        ],
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Tv\Hacks\ZendViewRendererFactory::class,

            Zend\View\HelperPluginManager::class =>
                Zend\Expressive\ZendView\HelperPluginManagerFactory::class,
        ],
    ],

    'templates' => [
        'layout' => 'layout/default',
        'map' => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error'    => 'templates/error/error.phtml',
            'error/404'      => 'templates/error/404.phtml',
        ],
        'paths' => [
            'page'    => ['templates/page'],
            'channel' => ['templates/channel'],
            'auth'    => ['templates/auth'],
            'layout'  => ['templates/layout'],
            'error'   => ['templates/error'],
        ],
    ],

    'view_helpers' => [
        'factories' => [
            'ident' => Tv\Auth\ViewHelper\IdentityFactory::class,
            'csrfToken' => Tv\App\ViewHelper\CsrfTokenFactory::class,
            'routeParam' => Tv\App\ViewHelper\RouteParamFactory::class,
        ],
        // zend-servicemanager-style configuration for adding view helpers:
        // - 'aliases'
        // - 'invokables'
        // - 'factories'
        // - 'abstract_factories'
        // - etc.
    ],
];
