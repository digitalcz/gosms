<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageDeliveryRecipients extends BaseResource
{
    /** @var array<string, string> */
    public array $delivered;

    /** @var array<string, string> */
    public array $undelivered;

    /** @var array<string, string> */
    public array $delivering;
}
