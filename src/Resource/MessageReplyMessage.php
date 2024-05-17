<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

use DateTime;

class MessageReplyMessage extends BaseResource
{
    public int $id;
    public string $message;
    public string $recipient;
    public string $sourceNumber;
    public DateTime $received;
    public int $partsCount;
    public int $messageReferenceNumber;
}
