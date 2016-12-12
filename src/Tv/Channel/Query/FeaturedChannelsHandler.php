<?php
namespace Tv\Channel\Query;

use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Finder\VideoFinder;

final class FeaturedChannelsHandler
{
    private $channelFinder;

    private $videoFinder;

    public function __construct(ChannelFinder $channelFinder, VideoFinder $videoFinder)
    {
        $this->channelFinder = $channelFinder;
        $this->videoFinder = $videoFinder;
    }

    public function __invoke(FeaturedChannels $query)
    {
        $channels = $this->channelFinder->findAllFeatured();

        foreach ($channels as $key => $channel) {
            $thumbnails = $this->videoFinder->findThumbnailsByChannel($channel->id, 10);
            $channels[$key]->thumbnails = $thumbnails;
        }

        return $channels;
    }
}
