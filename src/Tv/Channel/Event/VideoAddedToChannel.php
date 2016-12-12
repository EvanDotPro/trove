<?php
namespace Tv\Channel\Event;

use EvantSource\ReadOnlyProperties;

class VideoAddedToChannel
{
    use ReadOnlyProperties;

    private $videoId;

    private $channelId;

    private $source;

    private $sourceId;

    private $userId;

    public function __construct(
        string $videoId,
        string $channelId,
        string $source,
        string $sourceId,
        string $userId
    )
    {
        $this->videoId = $videoId;
        $this->channelId = $channelId;
        $this->source = $source;
        $this->sourceId = $sourceId;
        $this->userId = $userId;
    }
}
