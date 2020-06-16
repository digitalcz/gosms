<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\SentMessage;

use PHPUnit\Framework\TestCase;

class RecipientsTest extends TestCase
{
    public function testConstruct(): void
    {
        $recipients = new Recipients(['Peter']);

        self::assertSame(['Peter'], $recipients->getInvalid());
        self::assertSame(['invalid' => ['Peter']], $recipients->toArray());
    }
}
