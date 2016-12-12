<?php
namespace Tv\App\Middleware;

use Interop\Container\ContainerInterface;

class ValidateCqrsPayloadFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ValidateCqrsPayload($container->get('session'));
    }
}
