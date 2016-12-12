<?php
namespace Tv\Video;

use PDO;

class Mapper implements MapperInterface
{
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchRandomVideos($channelId, $qty)
    {
        $select = $this->pdo->prepare('SELECT video_id FROM video WHERE channel_id = :channel_id AND approved = 1 ORDER BY RAND()');

        if (!$select->execute(['channel_id' => $channelId])) {
            return false;
        }

        return $select->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insertVideoForChannel($channelId, $videoId, $userId)
    {
        $select = $this->pdo->prepare('INSERT INTO video (video_id, channel_id, user_id, approved) VALUES (:video_id, :channel_id, :user_id, :approved);');
        $select->execute([
            'channel_id' => $channelId,
            'video_id' => $videoId,
            'user_id' => $userId,
            'approved' => 1,
        ]);
    }
}
