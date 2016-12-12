<?php
namespace Tv\Auth\Finder;

use Doctrine\DBAL\Connection;

class UserFinder
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

    public function findByUserId($userId)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s WHERE id = :userId", 'read_user'));
        $stmt->bindValue('userId', $userId);
        $stmt->execute();
        return $stmt->fetch();

    }

    public function findByUsername($username)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT * FROM %s WHERE username = :username", 'read_user'));
        $stmt->bindValue('username', $username);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function usernameIsAvailable($username)
    {
        $stmt = $this->connection->prepare(sprintf("SELECT EXISTS (SELECT 1 FROM %s WHERE username = :username) AS available", 'read_user'));
        $stmt->bindValue('username', $username);
        $stmt->execute();

        return ! (bool) $stmt->fetch()->available;
    }
}

