<?php
namespace Tv\Video;

interface MapperInterface
{
    public function fetchRandomVideos($channelId, $qty);

    public function insertVideoForChannel($channelId, $videoId, $userId);
}
