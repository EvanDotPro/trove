<?php
namespace Tv\App\ViewHelper;

use Interop\Container\ContainerInterface;

class CsrfTokenFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new CsrfToken(
            $container->get('session')
        );
    }
}
