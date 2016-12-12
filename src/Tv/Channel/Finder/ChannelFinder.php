<?php
namespace Tv\Channel\Finder;

use Doctrine\DBAL\Connection;

class ChannelFinder
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

    public function pathIsAvailable($path)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT EXISTS (SELECT 1 FROM %s WHERE path = :path) AS available", 'read_channel'));
        $stmt->bindValue('path', $path);
        $stmt->execute();
        return ! (bool) $stmt->fetch()->available;
    }

    public function findChannelByPath($path)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s WHERE path = :path", 'read_channel'));
        $stmt->bindValue('path', $path);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findAllFeatured()
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s AS c JOIN read_channel_featured AS f ON f.id = c.id", 'read_channel'));
        $stmt->execute();
        return $stmt->fetchAll();

    }
}
