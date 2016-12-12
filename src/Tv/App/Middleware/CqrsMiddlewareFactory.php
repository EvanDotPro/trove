<?php
declare(strict_types=1);

namespace Tv\App\Middleware;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use EvantSource\DomainDispatcher;
use EvantSource\MessageSerializer;
use Tv\Auth\AuthService;

class CqrsMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): CqrsMiddleware
    {
        return new CqrsMiddleware(
            $container->get(DomainDispatcher::class),
            new MessageSerializer,
            $container->get(AuthService::class)
        );
    }
}
