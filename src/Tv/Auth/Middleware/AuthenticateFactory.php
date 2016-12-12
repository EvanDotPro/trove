<?php
namespace Tv\Auth\Middleware;

use Interop\Container\ContainerInterface;
use Tv\Auth\AuthService;

class AuthenticateFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Authenticate(
            $container->get(AuthService::class)
        );
    }
}
