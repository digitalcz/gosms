<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DigitalCz\GoSms\ValueObject\SentMessage\Recipients;
use PHPUnit\Framework\TestCase;

class SentMessageTest extends TestCase
{
    public function testConstruct(): void
    {
        $recipients = new Recipients(['Peter']);

        $sentMessage = new SentMessage($recipients, 'api/v1/messages/1');

        self::assertSame('api/v1/messages/1', $sentMessage->getLink());
        self::assertSame($recipients, $sentMessage->getRecipients());
        self::assertSame(1, $sentMessage->getMessageId());
    }

    public function testFromArray(): void
    {
        $sentMessage = SentMessage::fromArray(
            ['recipients' => ['invalid' => ['Peter']], 'link' => 'api/v1/messages/1']
        );

        self::assertSame('api/v1/messages/1', $sentMessage->getLink());
        self::assertEquals(new Recipients(['Peter']), $sentMessage->getRecipients());
        self::assertSame(1, $sentMessage->getMessageId());
    }
}
