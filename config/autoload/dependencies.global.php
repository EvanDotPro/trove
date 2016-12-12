<?php
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'abstract_factories' => [
            Tv\App\FactoryResolverAbstractFactory::class,
        ],
        'invokables' => [
            //Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
            Tv\App\Helper\RouteResultHelper::class => Tv\App\Helper\RouteResultHelper::class,
        ],
        'factories' => [

            'doctrine.connection.default' => \Tv\Db\DoctrineDbalConnectionFactory::class,
            PDO::class => Tv\Db\PdoFactory::class,

            'session' => Tv\Auth\SessionFactory::class,

            Application::class => ApplicationFactory::class,
            //Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Tv\Channel\MapperInterface::class => Tv\Channel\MapperFactory::class,
            Tv\Channel\ServiceInterface::class => Tv\Channel\ServiceFactory::class,
            Tv\Auth\MapperInterface::class => Tv\Auth\MapperFactory::class,
            Tv\Auth\ServiceInterface::class => Tv\Auth\ServiceFactory::class,
            Tv\Video\MapperInterface::class => Tv\Video\MapperFactory::class,
            Tv\Video\ServiceInterface::class => Tv\Video\ServiceFactory::class,
        ],
    ],
];
