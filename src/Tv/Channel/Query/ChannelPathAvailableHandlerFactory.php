<?php
namespace Tv\Channel\Query;

use Interop\Container\ContainerInterface;
use Tv\Channel\Finder\ChannelFinder;

final class ChannelPathAvailableHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $channelFinder = $container->get(ChannelFinder::class);

        return new ChannelPathAvailableHandler($channelFinder);
    }
}

