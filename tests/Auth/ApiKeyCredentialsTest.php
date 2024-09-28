<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;
use DigitalCz\GoSms\GoSmsClient;
use Http\Mock\Client;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DigitalCz\GoSms\Auth\ApiKeyCredentials
 */
class ApiKeyCredentialsTest extends TestCase
{
    public function testHash(): void
    {
        $credentials = new ApiKeyCredentials('foo', 'bar');
        self::assertSame('3858f62230ac3c915f300c664312c63f', $credentials->getHash());
    }

    public function testProvide(): void
    {
        $mockClient = new Client();
        $mockClient->addResponse(new Response(200, [], '{"accessToken": "moo","expiresIn":123}'));

        $goSms = new GoSms(['client' => new GoSmsClient($mockClient)]);

        $credentials = new ApiKeyCredentials('foo', 'bar');
        $token = $credentials->provide($goSms);

        self::assertSame('moo', $token->getToken());
        self::assertSame(123, $token->getTtl());
    }
}
