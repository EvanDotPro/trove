<?php
namespace Tv\Auth\Finder;

use Interop\Container\ContainerInterface;

final class UserFinderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UserFinder($container->get('doctrine.connection.default'));
    }
}
