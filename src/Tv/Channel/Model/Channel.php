<?php
namespace Tv\Channel\Model;

use EvantSource\ReadOnlyProperties;
use EvantSource\AggregateRootTrait;

use Tv\Channel\Event\ChannelCreated;

class Channel
{
    use AggregateRootTrait;
    use ReadOnlyProperties;

    private $channelId;

    private $ownerId;

    private $name;

    private $path;

    private $featured = 0;

    public function aggregateId()
    {
        return $this->channelId;
    }

    public static function createNewChannel(
        string $channelId,
        string $ownerId,
        string $name,
        string $path
    )
    {
        $self = new self;

        $self->applyEvent(new ChannelCreated($channelId, $ownerId, $name, $path));

        return $self;
    }

    public function whenChannelCreated(ChannelCreated $e)
    {
        $this->channelId = $e->channelId;
        $this->ownerId = $e->userId;
        $this->name = $e->name;
        $this->path = $e->path;
    }
}
