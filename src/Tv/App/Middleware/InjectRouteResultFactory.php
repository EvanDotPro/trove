<?php
declare(strict_types=1);

namespace Tv\App\Middleware;

use Interop\Container\ContainerInterface;
use Tv\App\Helper\RouteResultHelper;

class InjectRouteResultFactory
{
    public function __invoke(ContainerInterface $container): InjectRouteResult
    {
        return new InjectRouteResult(
            $container->get(RouteResultHelper::class)
        );
    }
}

