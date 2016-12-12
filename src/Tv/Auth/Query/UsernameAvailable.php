<?php
declare(strict_types=1);

namespace Tv\Auth\Query;

use EvantSource\ReadOnlyProperties;

class UsernameAvailable
{
    use ReadOnlyProperties;

    private $username;
}
