<?php
namespace Tv\Channel\Finder;

use Doctrine\DBAL\Connection;

class VideoFinder
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(\PDO::FETCH_OBJ);
    }

    public function findRandomByChannel($channelId)
    {
        $query = <<<sql
SELECT sourceId, source
FROM read_video
WHERE channelId = :channelId
ORDER BY RAND()
LIMIT 1;
sql;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('channelId', $channelId);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findThumbnailsByChannel($channelId, $quantity)
    {
        $query = <<<sql
SELECT sourceId
FROM read_video
WHERE channelId = :channelId
ORDER BY RAND()
LIMIT :qty;
sql;

        $stmt = $this->connection->prepare($query);
        $stmt->bindValue('channelId', $channelId);
        $stmt->bindValue('qty', $quantity, \PDO::PARAM_INT);
        $stmt->execute();
        $videos = $stmt->fetchAll();

        $thumbnails = [];

        foreach ($videos as $video) {
            $thumbnails[] = "https://i.ytimg.com/vi/{$video->sourceId}/hqdefault.jpg";
        }

        return $thumbnails;
    }
}
