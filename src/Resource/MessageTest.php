<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageTest extends BaseResource
{
    public string $messageType;
    public MessageMessage $message;
    public int $channel;
    public MessageStats $stats;
    public MessageSendingInfo $sendingInfo;
    public MessageReply $reply;
}
