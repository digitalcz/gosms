<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class SendMessageTest extends TestCase
{
    public function testConstruct(): void
    {
        $sendMessage = new SendMessage('Hello Hans!', ['+420775300500'], 1);

        self::assertSame('Hello Hans!', $sendMessage->getMessage());
        self::assertSame(['+420775300500'], $sendMessage->getRecipients());
        self::assertSame(1, $sendMessage->getChannel());
    }

    public function testToArray(): void
    {
        $sendMessage = new SendMessage('Hello Hans!', ['+420775300500'], 1);

        self::assertSame(
            [
                'message' => 'Hello Hans!',
                'recipients' => ['+420775300500'],
                'channel' => 1,
            ],
            $sendMessage->toArray(),
        );

        $time = new DateTimeImmutable('3600');

        $sendMessage = new SendMessage('Hello Hans!', ['+420775300500'], 1);
        $sendMessage->setExpectedSendStart($time);

        self::assertSame(
            [
                'message' => 'Hello Hans!',
                'recipients' => ['+420775300500'],
                'channel' => 1,
                'expectedSendStart' => $time->format('c'),
            ],
            $sendMessage->toArray(),
        );
    }

    public function testExpectedStart(): void
    {
        $time = new DateTimeImmutable('3600');

        $sendMessage = new SendMessage('Hello Hans!', ['+420775300500'], 1);
        $sendMessage->setExpectedSendStart($time);

        self::assertSame($time, $sendMessage->getExpectedSendStart());
    }
}
