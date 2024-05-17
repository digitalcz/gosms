<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageReply extends BaseResource
{
    public bool $hasReplies;
    public int $repliesCount;

    /** @var array<int, string> */
    public array $recipients;
}
