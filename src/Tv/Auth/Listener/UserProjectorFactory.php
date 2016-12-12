<?php
namespace Tv\Auth\Listener;

use Interop\Container\ContainerInterface;
use Tv\Auth\Finder\UserFinder;

final class UserProjectorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UserProjector(
            $container->get('doctrine.connection.default'),
            $container->get(UserFinder::class)
        );
    }
}


