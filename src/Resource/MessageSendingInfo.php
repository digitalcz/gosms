<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

use DateTimeImmutable;

class MessageSendingInfo extends BaseResource
{
    public string $status;
    public DateTimeImmutable $expectedSendStart;
    public DateTimeImmutable $sentStart;
    public DateTimeImmutable $sentFinish;
}
