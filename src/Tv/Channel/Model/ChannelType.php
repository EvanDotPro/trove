<?php
declare(strict_types=1);

namespace Tv\Channel\Model;

final class ChannelType
{
    const PUBLIC = "open";
    const RESTRICTED = "done";
    const EXPIRED = "expired";

    /**
     * @var string
     */
    private $status;

