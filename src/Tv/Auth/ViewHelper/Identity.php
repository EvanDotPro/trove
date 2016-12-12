<?php
namespace Tv\Auth\ViewHelper;

use Zend\View\Helper\AbstractHelper;
use Tv\Auth\AuthService;

final class Identity extends AbstractHelper
{
    private $authService;

    public function __construct(AuthService $service)
    {
        $this->authService = $service;
    }

    public function __invoke()
    {
        if (!$this->authService->hasIdentity()) {
            return false;
        }

        return $this->authService->getIdentity();
    }
}
