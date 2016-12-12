<?php
declare(strict_types=1);

namespace Tv\Channel\Command;

use EvantSource\ReadOnlyProperties;

class CreateChannel
{
    use ReadOnlyProperties;

    private $channelId;

    private $userId;

    private $name;

    private $path;

    private function __construct(){}
}
