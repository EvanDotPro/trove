<?php
namespace Tv\Channel\Model;

use EvantSource\ReadOnlyProperties;
use EvantSource\AggregateRootTrait;

use Tv\Channel\Event\VideoAddedToChannel;

class Video
{
    use AggregateRootTrait;
    use ReadOnlyProperties;

    private $videoId;

    private $channelId;

    private $source;

    private $sourceId;

    private $userId;

    public function aggregateId()
    {
        return $this->videoId;
    }

    public static function addToChannel(
        string $videoId,
        string $channelId,
        string $source,
        string $sourceId,
        string $userId
    )
    {
        $self = new self;

        $self->applyEvent(new VideoAddedToChannel(
            $videoId,
            $channelId,
            $source,
            $sourceId,
            $userId
        ));

        return $self;
    }

    public function whenVideoAddedToChannel(VideoAddedToChannel $e)
    {
        $this->videoId = $e->videoId;
        $this->channelId = $e->channelId;
        $this->source = $e->source;
        $this->sourceId = $e->sourceId;
        $this->userId = $e->userId;
    }
}
