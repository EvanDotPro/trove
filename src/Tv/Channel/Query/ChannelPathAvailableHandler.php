<?php
namespace Tv\Channel\Query;

use Tv\Channel\Finder\ChannelFinder;

final class ChannelPathAvailableHandler
{
    private $channelFinder;

    public function __construct(ChannelFinder $channelFinder)
    {
        $this->channelFinder = $channelFinder;
    }

    public function __invoke(ChannelPathAvailable $query)
    {
        $available = $this->channelFinder->pathIsAvailable($query->path);

        return $available;
    }
}
