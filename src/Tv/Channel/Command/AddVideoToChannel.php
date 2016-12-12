<?php
namespace Tv\Channel\Command;

use EvantSource\ReadOnlyProperties;

class AddVideoToChannel
{
    use ReadOnlyProperties;

    private $videoId;

    private $channelId;

    private $userId;

    private $videoUrl;
}
