<?php
namespace Tv\Video;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Tv\Auth\AuthService;

class ServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $mapper = $container->get(MapperInterface::class);
        $authService = $container->get(AuthService::class);

        return new Service($mapper, $authService);
    }
}
