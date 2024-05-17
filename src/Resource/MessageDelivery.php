<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageDelivery extends BaseResource
{
    public bool $isDelivered;
    public int $smsCount;
    public int $deliveredSmsCount;
    public MessageDeliveryRecipients $recipients;
}
