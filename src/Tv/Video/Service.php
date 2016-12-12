<?php
namespace Tv\Video;

use Tv\Auth\AuthService;

class Service implements ServiceInterface
{
    public function __construct(MapperInterface $mapper, AuthService $authService)
    {
        $this->mapper = $mapper;
        $this->authService = $authService;
    }

    public function getChannelThumbnails($channelId, $quantity)
    {
        $videoIDs = $this->mapper->fetchRandomVideos($channelId, $quantity);
        $thumbnailUrls = [];

        foreach ($videoIDs as $videoID) {
            $thumbnailUrls[] = "https://i.ytimg.com/vi/{$videoID}/hqdefault.jpg";
        }

        return $thumbnailUrls;
    }

    public function getChannelVideos($channelId, $quantity)
    {
        return $this->mapper->fetchRandomVideos($channelId, $quantity);
    }

    public function addVideosToChannel($channelId, $videoIds)
    {
        if (!$this->authService->hasIdentity()) {
            return false;
        }

        $user = $this->authService->getIdentity();

        $parsedIds = [];

        foreach (explode("\n", $videoIds) as $line) {
            if (strpos('http', $line) !== false) {
                parse_str( parse_url( $line, PHP_URL_QUERY ), $params );
                $parsedIds[] = $params['v'];
            } else {
                $parsedIds[] = $line;
            }
        }

        foreach ($parsedIds as $videoID) {
            $this->mapper->insertVideoForChannel($channelId, $videoID, $user['id']);
        }
    }
}
