<?php
namespace Tv\Video;

interface ServiceInterface
{
    public function getChannelThumbnails($channelId, $quantity);

    public function getChannelVideos($channelId, $quantity);

    public function addVideosToChannel($channelId, $videoIds);

}
