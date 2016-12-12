<?php
declare(strict_types=1);

namespace Tv\Channel\Event;

use EvantSource\ReadOnlyProperties;

class ChannelFeatured
{
    use ReadOnlyProperties;

    private $channelId;

    private $userId;

    public function __construct(
        string $channelId,
        string $userId
    )
    {
        $this->channelId = $channelId;
        $this->userId    = $userId;
    }
}
