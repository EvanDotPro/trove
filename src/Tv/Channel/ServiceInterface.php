<?php
namespace Tv\Channel;

interface ServiceInterface
{
    public function getChannelByUrl($url);

    public function getFeaturedChannels();

}
