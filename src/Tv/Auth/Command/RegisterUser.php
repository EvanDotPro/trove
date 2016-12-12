<?php
declare(strict_types=1);

namespace Tv\Auth\Command;

use EvantSource\ReadOnlyProperties;

class RegisterUser
{
    use ReadOnlyProperties;

    private $userId;

    private $username;

    private $passwordHash;
}
