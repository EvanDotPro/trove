<?php
namespace Tv\Auth;

use Aura\Session\Session as AuraSession;
use Aura\Session\SessionFactory as AuraSessionFactory;
use Interop\Container\ContainerInterface;

class SessionFactory
{
    public function __invoke() : AuraSession
    {
        $factory = new AuraSessionFactory;
        $session = $factory->newInstance($_COOKIE);
        $session->setCookieParams(array('lifetime' => '1209600'));

        return $session;
    }
}
