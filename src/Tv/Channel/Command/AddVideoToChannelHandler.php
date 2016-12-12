<?php
namespace Tv\Channel\Command;

use EvantSource\AggregateRepository;
use Tv\Channel\Finder\VideoFinder;
use Tv\Channel\Model\Video;

final class AddVideoToChannelHandler
{
    private $videoFinder;

    private $repository;

    public function __construct(AggregateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddVideoToChannel $command)
    {
        // $this->rbac->isGranted($userRole, $command)
        //if (!$this->videoFinder->channelHasVideo($command->channelId, $command->sourceId)) {
        //    throw new \Exception('Channel already has that video.');
        //}
        $source = $this->videoSource($command->videoUrl);
        $method = "{$source}Id";
        $sourceId = $this->{$method}($command->videoUrl);

        //var_dump($source);
        //var_dump($videoId);
        //die();

        $video = Video::addToChannel(
            $command->videoId,
            $command->channelId,
            $source,
            $sourceId,
            $command->userId
        );

        $this->repository->save($video);
    }

    private function videoSource($url)
    {
        if (strpos($url, 'youtube.com') !== false) return 'youtube';
        if (strpos($url, 'videmo.com') !== false) return 'vimeo';
    }

    private function youtubeId($url)
    {
        parse_str( parse_url( $url, PHP_URL_QUERY ), $params );
        return $params['v'];
    }
}

