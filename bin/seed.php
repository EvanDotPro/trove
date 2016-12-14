<?php
use Tv\Auth\Event\UserRegistered;
use Tv\Channel\Event\ChannelCreated;
use Tv\Channel\Event\ChannelFeatured;
use Tv\Channel\Event\VideoAddedToChannel;

chdir(dirname(__DIR__));

require 'vendor/autoload.php';

$container = require 'config/container.php';

$evanUserId = 'cd878ea9-c50f-453d-bcc6-241d91258584';
$jeffUserId = 'c0d0033a-d56b-4362-8100-4192bdc55a63';

$channels = [
    [
        'id' => 'f46795fb-6826-438e-a1ef-4c7f6449a21d',
        'name' => 'Explore',
        'path' => 'explore',
        'videos' => [
            '0DU8LTTGtx0',
            '0E-KnJB24Ss',
            '2f8Hpid8YWA',
            'ao8L-0nSYzg',
            'e-P5IFTqB98',
            'gmJgW-yMAIg',
            'KJDEsAy9RyM',
            'LbYOdS9_vo0',
            'MnExgQ81fhU',
            'o9w--QlbiW0',
            'OiogsJ_erYA',
            'paP3r1Q0xfk',
            'RWMYNTnoEyQ',
            'TGx8rjgdIXk',
            'wvVYBNCrhrU',
            'xe-f4gokRBs',
            'XRCIzZHpFtY',
            'y8mzDvpKzfY',
            'yCAPIynGgYo',
            'z8pg-s9DKYo',
            'zz6v6OfoQvs',
            '_pbdwueqGp4',
        ],
    ],

    [
        'id' => '1aec3c97-94be-4dd5-b6f3-6691eb07b70a',
        'name' => 'Food',
        'path' => 'food',
        'videos' => [
            '-1hTK0wGrTg',
            '3qdnnhgu4FE',
            '5hnFxU88NWI',
            '9xVILL4n5Eo',
            'An9FA6a8dyc',
            'AWjBNSshF3s',
            'F0iv1YFaoxQ',
            'fxipEj0aOIM',
            'g3q-ze3oKcE',
            'GXRouroc_ZY',
            'HCNwSe3t8ek',
            'iqhJvadqtAc',
            'JMP8_HioNqU',
            'LdfX_lN5n0E',
            'm9FRSghXhDM',
            'oTfgfoVb6io',
            'pFKs2nz2qEc',
            'Q5owUMujik0',
            'QO_V3h14Fyc',
            'wuKcDUi8kqs',
            'yCrbv81SBHg',
            'ZJy1ajvMU1k',
        ],
    ],

    [
        'id' => 'baeb95e8-f968-421d-8876-306d97dde60e',
        'name' => 'Comedy',
        'path' => 'comedy',
        'videos' => [
            '-rSDUsMwakI',
            'aSsH6tYBgD8',
            'ge461sByyT8',
            'QqugCQzWOYA',
            'SHG0ezLiVGc',
            'Sn-euM4TBp4',
        ],
    ],

    [
        'id' => 'adacde77-3550-4dda-8717-371b11006d63',
        'name' => 'Action',
        'path' => 'action',
        'videos' => [
            'gl1n79s3vRw',
            'jxS8EUxmlx8',
            'lq-54gox6-k',
            'uAz9hZmcr58',
        ],
    ],

    [
        'id' => '72c3a0e8-43c5-499a-9ff6-f3b05dcc9701',
        'name' => 'Raw Politics',
        'path' => 'raw_politics',
        'videos' => [
            'AQPlREDW-Ro',
            'cL_wh-d1pP4',
            'GpWQHFzrEqc',
            'khK9fIgoNjQ',
            'NUBN_nsl5jI',
            'RvOnXh3NN9w',
            'Tjl8ka3F6QU',
            'ZYkxVbYxy-c',
        ],
    ],

    [
        'id' => '5f90d522-ddff-4fd6-9b41-c3f13568122d',
        'name' => 'Aviation',
        'path' => 'aviation',
        'user' => $jeffUserId,
        'videos' => [
            'c26y2-j5KrY',
            'ew8NYGY5qnc',
            'hfLl_sv35Pk',
            'WtLwgxVDwfo',
            'zeBHR6NqxnQ',
        ],
    ],
];

$events = [];

$events[] = new UserRegistered(
    $evanUserId,
    'EvanDotPro',
    '$2y$10$tFHqA4QkZCzIJMJrOGNqTe.4.uxZdjhq0ZDrL6RKL3aJSOBtFuYZC'
);

$events[] = new UserRegistered(
    $jeffUserId,
    'jchristianson',
    '$2y$10$N0hioPUptkJD26.M17KlD.QI3bS6Yh7ZyDHbqLBLuOjJiRJ23UxTK'
);

foreach ($channels as $channel) {

    $userId = isset($channel['user']) ? $channel['user'] : $evanUserId;
    $events[] = new ChannelCreated(
        $channel['id'],
        $userId,
        $channel['name'],
        $channel['path']
    );

    $events[] = new ChannelFeatured(
        $channel['id'],
        $evanUserId
    );

    foreach ($channel['videos'] as $video) {

        $events[] = new VideoAddedToChannel(
            \Ramsey\Uuid\Uuid::uuid4()->toString(),
            $channel['id'],
            'youtube',
            $video,
            $userId
        );
    }
}


$dispatcher = $container->get(EvantSource\DomainDispatcher::class);
$appendStore = new EvantSource\PhpAppendStore('data/event_store');
$serializer = new EvantSource\MessageSerializer;

foreach ($events as $event) {
    $class = get_class($event);

    switch ($class) {
        case UserRegistered::class:
            $id = $event->userId;
            break;
        case Tv\Channel\Event\ChannelCreated::class:
            $id = $event->channelId;
            break;
        case Tv\Channel\Event\VideoAddedToChannel::class:
            $id = $event->videoId;
            break;
        case Tv\Channel\Event\ChannelFeatured::class:
            $id = \Ramsey\Uuid\Uuid::uuid4()->toString();
            break;
    }

    $payload = $serializer->serialize($event);
    $appendStore->append($id, $payload, ['type' => $class], 0);
    $dispatcher->dispatch($event);
}
