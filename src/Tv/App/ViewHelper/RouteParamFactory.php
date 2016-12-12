<?php
namespace Tv\App\ViewHelper;

use Interop\Container\ContainerInterface;
use Tv\App\Helper\RouteResultHelper;
use Zend\View\HelperPluginManager;

class RouteParamFactory
{
    public function __invoke(ContainerInterface $container)
    {
        //$container = $container->get(HelperPluginManager::class)
        return new RouteParam(
            $container->get(RouteResultHelper::class)
        );
    }
}
