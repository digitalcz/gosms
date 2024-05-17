<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageRecipients extends BaseResource
{
    /** @var array<int, string> */
    public array $sent;

    /** @var array<int, string> */
    public array $notSent;

    /** @var array<int, string> */
    public array $invalid;
}
