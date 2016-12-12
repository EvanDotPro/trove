<?php
namespace Tv\Channel;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Tv\Video\ServiceInterface as VideoServiceInterface;

class ServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(MapperInterface::class);
        $videoService = $container->get(VideoServiceInterface::class);

        return new Service($mapper, $videoService);
    }
}
