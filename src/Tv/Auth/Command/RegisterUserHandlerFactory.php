<?php
namespace Tv\Auth\Command;

use Interop\Container\ContainerInterface;
use EvantSource\AggregateRepository;
use Tv\Auth\Finder\UserFinder;

final class RegisterUserHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $userFinder = $container->get(UserFinder::class);
        $repository = $container->get(AggregateRepository::class);

        return new RegisterUserHandler($userFinder, $repository);
    }
}

