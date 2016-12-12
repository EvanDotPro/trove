<?php
namespace Tv\Auth\Query;

use Interop\Container\ContainerInterface;
use Tv\Auth\Finder\UserFinder;

final class UsernameAvailableHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userFinder = $container->get(UserFinder::class);

        return new UsernameAvailableHandler($userFinder);
    }
}
