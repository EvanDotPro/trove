<?php
namespace Tv\Channel;

use PDO;

class Mapper implements MapperInterface
{
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchChannelByUrl($url)
    {
        $select = $this->pdo->prepare('SELECT * FROM channel WHERE url = :url');

        if (!$select->execute([':url' => $url])) {
            return false;
        }

        return $select->fetch();
    }

    public function fetchFeaturedChannels()
    {
        $select = $this->pdo->prepare('SELECT * FROM channel WHERE featured = :featured');

        if (!$select->execute([':featured' => 1])) {
            return false;
        }

        return $select->fetchAll();
    }

    public function insertChannel($name, $url)
    {

        $select = $this->pdo->prepare('INSERT INTO channel (video_id, channel_id, user_id, approved) VALUES (:video_id, :channel_id, :user_id, :approved);');
        $select->execute([
            'url' => $url,
            'name' => $name,
        ]);

    }
}
