<?php
namespace Tv\Channel\Listener;

use Interop\Container\ContainerInterface;

final class ChannelProjectorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ChannelProjector(
            $container->get('doctrine.connection.default')
        );
    }
}
