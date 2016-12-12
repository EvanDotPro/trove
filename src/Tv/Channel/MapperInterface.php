<?php
namespace Tv\Channel;

interface MapperInterface
{
    public function fetchChannelByUrl($url);

    public function fetchFeaturedChannels();

    public function insertChannel($name, $url);
}
