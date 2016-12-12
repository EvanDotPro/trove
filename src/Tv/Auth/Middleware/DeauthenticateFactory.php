<?php
namespace Tv\Auth\Middleware;

use Interop\Container\ContainerInterface;
use Tv\Auth\AuthService;

class DeauthenticateFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Deauthenticate(
            $container->get(AuthService::class)
        );
    }
}
