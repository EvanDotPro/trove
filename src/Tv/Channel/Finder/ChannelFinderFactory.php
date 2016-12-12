<?php
namespace Tv\Channel\Finder;

use Interop\Container\ContainerInterface;

final class ChannelFinderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ChannelFinder($container->get('doctrine.connection.default'));
    }
}
