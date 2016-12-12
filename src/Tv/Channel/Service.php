<?php
namespace Tv\Channel;

use Tv\Channel\Finder\VideoFinder;

class Service implements ServiceInterface
{
    public function __construct(MapperInterface $mapper, VideoFinder $videoFinder)
    {
        $this->mapper = $mapper;
        $this->videoFinder = $videoFinder;
    }

    public function getChannelByUrl($url)
    {
        return $this->mapper->fetchChannelByUrl($url);
    }

    public function getFeaturedChannels()
    {

        $channels = $this->mapper->fetchFeaturedChannels();

        foreach ($channels as $key => $channel) {
            $thumbnails = $this->videoFinder->findThumbnailsByChannel($channel['id'], 3);
            $channels[$key]['thumbnails'] = $thumbnails;
        }

        return $channels;
    }
}

