<?php
namespace Tv\Channel\Query;

use Interop\Container\ContainerInterface;
use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Finder\VideoFinder;

final class VideoToWatchHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new VideoToWatchHandler(
            $container->get(VideoFinder::class)
        );
    }
}
