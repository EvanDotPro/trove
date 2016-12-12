<?php
declare(strict_types=1);

namespace Tv\Channel\Listener;

use Doctrine\DBAL\Connection;
use Tv\Channel\Event\ChannelCreated;
use Tv\Channel\Event\ChannelFeatured;
use Tv\Channel\Event\ChannelUnfeatured;
use Tv\Channel\Event\VideoAddedToChannel;

class ChannelProjector
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function __invoke($event)
    {
        switch(get_class($event)) {
            case ChannelCreated::class:
                $this->whenChannelCreated($event);
                break;
            case ChannelFeatured::class:
                $this->whenChannelFeatured($event);
                break;
            case VideoAddedToChannel::class:
                $this->whenVideoAddedToChannel($event);
                break;
        }
    }

    public function whenChannelCreated(ChannelCreated $event)
    {
        $this->connection->insert('read_channel', [
            'id' => $event->channelId,
            'ownerId' => $event->userId,
            'name' => $event->name,
            'path' => $event->path,
        ]);
    }

    public function whenChannelFeatured(ChannelFeatured $event)
    {
        $this->connection->insert('read_channel_featured',[
            'id' => $event->channelId,
        ]);
    }

    public function whenChannelUnfeatured(ChannelUnfeatured $event)
    {
        $this->connection->delete('read_channel_featured',[
            'id' => $event->channelId,
        ]);
    }

    public function whenVideoAddedToChannel(VideoAddedToChannel $event)
    {
        $this->connection->insert('read_video', [
            'videoId' => $event->videoId,
            'channelId' => $event->channelId,
            'source' => $event->source,
            'sourceId' => $event->sourceId,
            'userId' => $event->userId,
        ]);
    }
}
