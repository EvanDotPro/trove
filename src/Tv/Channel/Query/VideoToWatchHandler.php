<?php
namespace Tv\Channel\Query;

use Tv\Channel\Finder\VideoFinder;

final class VideoToWatchHandler
{
    private $videoFinder;

    public function __construct(VideoFinder $videoFinder)
    {
        $this->videoFinder = $videoFinder;
    }

    public function __invoke(VideoToWatch $query)
    {
        return $this->videoFinder->findRandomByChannel($query->channelId);
    }
}
