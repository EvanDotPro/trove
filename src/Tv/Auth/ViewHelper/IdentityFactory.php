<?php
namespace Tv\Auth\ViewHelper;

use Interop\Container\ContainerInterface;
use Tv\Auth\AuthService;

class IdentityFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Identity(
            $container->get(AuthService::class)
        );
    }
}
