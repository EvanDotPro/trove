<?php
namespace Tv\Channel\Command;

use EvantSource\AggregateRepository;
use Tv\Channel\Finder\ChannelFinder;
use Tv\Channel\Model\Channel;

final class CreateChannelHandler
{
    private $channelFinder;

    private $repository;

    public function __construct(ChannelFinder $channelFinder, AggregateRepository $repository)
    {
        $this->channelFinder = $channelFinder;
        $this->repository = $repository;
    }

    public function __invoke(CreateChannel $command)
    {
        // $this->rbac->isGranted($userRole, $command)
        if (!$this->channelFinder->pathIsAvailable($command->path)) {
            throw new \Exception('Channel path is already registered.');
        }

        $channel = Channel::createNewChannel(
            $command->channelId,
            $command->userId,
            $command->name,
            $command->path
        );

        $this->repository->save($channel);
    }
}
