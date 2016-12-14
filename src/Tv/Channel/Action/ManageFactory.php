<?php
namespace Tv\Channel\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Finder\VideoFinder;

class ManageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $template = ($container->has(TemplateRendererInterface::class))
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new Manage(
            $template,
            $container->get(ChannelFinder::class),
            $container->get(VideoFinder::class)
        );
    }
}

