<?php
namespace Tv\Channel\Model;

final class VideoSource
{
    const YOUTUBE = "youtube";

    private $source;

    /**
     * @return VideoSource
     */
    public static function youtube()
    {
        return new self(self::YOUTUBE);
    }

    private function __construct($source)
    {
        if ( !in_array($source, [self::YOUTUBE]) ) {
            throw new \Exception('Invalid video source');
        }

        $this->source = $source;
    }
}
