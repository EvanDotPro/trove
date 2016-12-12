<?php
namespace Tv\Channel\Command;

use Interop\Container\ContainerInterface;
use EvantSource\AggregateRepository;
use Tv\Channel\Finder\ChannelFinder;

final class AddVideoToChannelHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AddVideoToChannelHandler(
            $container->get(AggregateRepository::class)
        );
    }
}


