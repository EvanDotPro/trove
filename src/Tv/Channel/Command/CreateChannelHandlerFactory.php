<?php
namespace Tv\Channel\Command;

use Interop\Container\ContainerInterface;
use EvantSource\AggregateRepository;
use Tv\Channel\Finder\ChannelFinder;

final class CreateChannelHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CreateChannelHandler(
            $container->get(ChannelFinder::class),
            $container->get(AggregateRepository::class)
        );
    }
}

