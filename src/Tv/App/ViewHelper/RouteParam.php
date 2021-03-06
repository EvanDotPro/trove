<?php
namespace Tv\App\ViewHelper;

use Zend\View\Helper\AbstractHelper;
use Zend\Expressive\Router\RouteResult;
use Tv\App\Helper\RouteResultHelper;

final class RouteParam extends AbstractHelper
{
    private $resultHelper;

    public function __construct(RouteResultHelper $resultHelper)
    {
        $this->resultHelper = $resultHelper;
    }

    public function __invoke($param)
    {
        $params = $this->resultHelper->getRouteResult()->getMatchedParams();

        if (!isset($params[$param])) {
            return false;
        }

        return $params[$param];
    }
}
