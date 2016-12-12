<?php
namespace Tv\Auth;

use Aura\Session\Session;
use Tv\Auth\Finder\UserFinder;
use Tv\Auth\Model\PasswordHash;

class AuthService
{
    private $finder;

    private $session;

    public function __construct(UserFinder $finder, Session $session)
    {
        $this->finder = $finder;
        $this->session = $session;
    }

    public function authenticate($username, $password)
    {
        $user = $this->finder->findByUsername($username);

        $userPassword = $user ? $user->password : 'n/a';

        if (!PasswordHash::fromHash($userPassword)->matches($password) || !$user) {
            return false;
        }

        if ($this->session->isStarted()) {
            $this->session->regenerateId();
        }

        $this->getSessionSegment()->set('user', $user);

        return true;
    }

    public function authenticateByUserId($usernameId, $password)
    {
        $user = $this->finder->findByUserId($userId);

        if (!PasswordHash::fromHash($user->password)->matches($password)) {
            return false;
        }

        if ($this->session->isStarted()) {
            $this->session->regenerateId();
        }

        $this->getSessionSegment()->set('user', $user);

        return true;
    }

    public function clearIdentity()
    {
        $this->getSessionSegment()->clear();
    }

    public function hasIdentity()
    {
        if ($this->getSessionSegment()->get('user')) {
            return true;
        }

        return false;
    }

    public function getIdentity()
    {
        return $this->getSessionSegment()->get('user');
    }

    private function getSessionSegment()
    {
        return $this->session->getSegment(self::class);
    }
}
