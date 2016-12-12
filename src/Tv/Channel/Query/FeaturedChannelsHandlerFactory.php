<?php
namespace Tv\Channel\Query;

use Interop\Container\ContainerInterface;
use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Finder\VideoFinder;

final class FeaturedChannelsHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new FeaturedChannelsHandler(
            $container->get(ChannelFinder::class),
            $container->get(VideoFinder::class)
        );
    }
}
