<?php
namespace Tv\Auth\Middleware;

use Interop\Container\ContainerInterface;
use Tv\Auth\AuthService;

class PopulateCurrentUserIdFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PopulateCurrentUserId(
            $container->get(AuthService::class)
        );
    }
}
