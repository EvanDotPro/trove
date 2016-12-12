<?php
namespace Tv\Auth\Command;

use Interop\Container\ContainerInterface;
use EvantSource\AggregateRepository;
use Tv\Auth\Finder\UserFinder;

final class ChangePasswordHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ChangePasswordHandler(
            $container->get(AggregateRepository::class)
        );
    }
}
