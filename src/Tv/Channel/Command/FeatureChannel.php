<?php
declare(strict_types=1);

namespace Tv\Channel\Command;

use EvantSource\ReadOnlyProperties;

class FeatureChannel
{
    use ReadOnlyProperties;

    private $channelId;

    private $userId;

    private function __construct(){}
}
