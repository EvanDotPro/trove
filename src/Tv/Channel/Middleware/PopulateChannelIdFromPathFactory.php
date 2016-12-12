<?php
namespace Tv\Channel\Middleware;

use Interop\Container\ContainerInterface;
use Tv\Channel\Finder\ChannelFinder;

class PopulateChannelIdFromPathFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new PopulateChannelIdFromPath(
            $container->get(ChannelFinder::class)
        );
    }
}
