<?php
namespace Tv\Auth\Command;

use Tv\Auth\Model\User;
use Tv\Auth\Finder\UserFinder;
use EvantSource\AggregateRepository;

final class ChangePasswordHandler
{
    private $repository;

    public function __construct(AggregateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ChangePassword $command)
    {
        $user = $this->repository->getById(User::class, $command->userId);

        $user->changePasswordHash($command->newPasswordHash);

        $this->repository->save($user);
    }
}
