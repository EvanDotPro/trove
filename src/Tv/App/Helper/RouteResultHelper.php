<?php
namespace Tv\App\Helper;

use Zend\Expressive\Router\RouteResult;

class RouteResultHelper
{
    private $result;

    public function setRouteResult(RouteResult $result)
    {
        $this->result = $result;
    }

    public function getRouteResult()
    {
        return $this->result;
    }
}
