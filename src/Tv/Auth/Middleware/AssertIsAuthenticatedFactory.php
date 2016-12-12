<?php
namespace Tv\Auth\Middleware;

use Interop\Container\ContainerInterface;
use Tv\Auth\AuthService;

class AssertIsAuthenticatedFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AssertIsAuthenticated(
            $container->get(AuthService::class)
        );
    }
}
