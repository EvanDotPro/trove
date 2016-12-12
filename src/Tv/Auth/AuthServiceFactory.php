<?php
namespace Tv\Auth;

use Interop\Container\ContainerInterface;
use Tv\Auth\Finder\UserFinder;

class AuthServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthService(
            $container->get(UserFinder::class),
            $container->get('session')
        );
    }
}
