<?php
declare(strict_types=1);

namespace Tv\Auth\Listener;

use Doctrine\DBAL\Connection;
use Tv\Auth\Event\UserRegistered;
use Tv\Auth\Event\PasswordChanged;
use Tv\Auth\Finder\UserFinder;

class UserProjector
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var UserFinder
     */
    private $userFinder;

    /**
     * @param Connection $connection
     * @param UserFinder $userFinder
     */
    public function __construct(Connection $connection, UserFinder $userFinder)
    {
        $this->connection = $connection;
        $this->userFinder = $userFinder;
    }

    public function __invoke($event)
    {
        switch(get_class($event)) {
            case UserRegistered::class:
                $this->onUserRegistered($event);
                break;
            case PasswordChanged::class:
                $this->onPasswordChanged($event);
                break;
        }
    }

    public function onPasswordChanged(PasswordChanged $event)
    {
        $this->connection->update('read_user',[
            'password' => $event->newPasswordHash,
        ], ['id' => $event->userId]);
    }

    public function onUserRegistered(UserRegistered $event)
    {
        $this->connection->insert('read_user', [
            'id' => $event->userId,
            'username' => $event->username,
            'password' => $event->passwordHash,
        ]);
    }
}
