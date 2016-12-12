<?php
declare(strict_types=1);

namespace Tv\Channel\Query;

use EvantSource\ReadOnlyProperties;

class VideoToWatch
{
    use ReadOnlyProperties;

    private $userId;

    private $channelId;
}
