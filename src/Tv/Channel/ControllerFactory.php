<?php
namespace Tv\Channel;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Tv\Video\ServiceInterface as VideoServiceInterface;

class ControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = ($container->has(TemplateRendererInterface::class))
            ? $container->get(TemplateRendererInterface::class)
            : null;

        $service = $container->get(ServiceInterface::class);
        $videoService = $container->get(VideoServiceInterface::class);

        return new Controller($template, $service, $videoService);
    }
}
