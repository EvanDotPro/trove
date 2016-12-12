<?php
namespace Tv\Channel\Finder;

use Interop\Container\ContainerInterface;

final class VideoFinderFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new VideoFinder($container->get('doctrine.connection.default'));
    }
}

