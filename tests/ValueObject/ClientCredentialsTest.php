<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use PHPUnit\Framework\TestCase;

class ClientCredentialsTest extends TestCase
{
    public function testConstruct(): void
    {
        $credentials = new ClientCredentials('client_id', 'client_secret');

        self::assertSame('client_id', $credentials->getClientId());
        self::assertSame('client_secret', $credentials->getClientSecret());
    }
}
