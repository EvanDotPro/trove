<?php
declare(strict_types=1);

namespace Tv\Channel\Event;

use EvantSource\ReadOnlyProperties;

class ChannelCreated
{
    use ReadOnlyProperties;

    private $channelId;

    private $userId;

    private $name;

    private $path;

    public function __construct(
        string $channelId,
        string $userId,
        string $name,
        string $path
    )
    {
        $this->channelId = $channelId;
        $this->userId    = $userId;
        $this->name      = $name;
        $this->path      = $path;
    }
}
