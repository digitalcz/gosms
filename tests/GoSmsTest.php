<?php

declare(strict_types=1);

namespace DigitalCz\GoSms;

use DigitalCz\GoSms\Auth\ApiKeyCredentials;
use DigitalCz\GoSms\Auth\CachedCredentials;
use DigitalCz\GoSms\Auth\Token;
use DigitalCz\GoSms\Auth\TokenCredentials;
use Http\Mock\Client;
use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\TestCase;
use stdClass;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * @covers \DigitalCz\GoSms\GoSms
 */
class GoSmsTest extends TestCase
{
    public function testCreateWithCredentials(): void
    {
        $goSms = new GoSms(['access_key' => 'foo', 'secret_key' => 'bar']);

        $credentials = $goSms->getCredentials();
        self::assertInstanceOf(ApiKeyCredentials::class, $credentials);
        self::assertSame('foo', $credentials->getAccessKey());
        self::assertSame('bar', $credentials->getSecretKey());
    }

    public function testPleaseProvideCredentialsException(): void
    {
        $goSms = new GoSms();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'No credentials were provided, Please use setCredentials() ' .
            'or constructor options to set them.',
        );
        $goSms->getCredentials();
    }

    public function testCreateWithCachedCredentials(): void
    {
        $goSms = new GoSms(
            [
                'access_key' => 'foo',
                'secret_key' => 'bar',
                'cache' => new Psr16Cache(new FilesystemAdapter()),
            ],
        );

        $credentials = $goSms->getCredentials();
        self::assertInstanceOf(CachedCredentials::class, $credentials);
        $credentials = $credentials->getInner();
        self::assertInstanceOf(ApiKeyCredentials::class, $credentials);
        self::assertSame('foo', $credentials->getAccessKey());
        self::assertSame('bar', $credentials->getSecretKey());
    }

    public function testCreateWithDoubleCachedCredentials(): void
    {
        $cache = new Psr16Cache(new FilesystemAdapter());
        $goSms = new GoSms(
            [
                'credentials' => new CachedCredentials(new TokenCredentials(new Token('foo', time())), $cache),
                'cache' => new Psr16Cache(new FilesystemAdapter()),
            ],
        );

        $credentials = $goSms->getCredentials();
        self::assertInstanceOf(CachedCredentials::class, $credentials);
        $credentials = $credentials->getInner();
        self::assertInstanceOf(TokenCredentials::class, $credentials);
    }

    public function testCreateWithInvalidCache(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value for "cache" option');
        new GoSms(['cache' => new stdClass()]); // @phpstan-ignore-line
    }

    public function testCreateWithCustomCredentials(): void
    {
        $token = new Token('foo', time());

        $goSms = new GoSms(['credentials' => new TokenCredentials($token)]);

        $credentials = $goSms->getCredentials();
        self::assertInstanceOf(TokenCredentials::class, $credentials);
        self::assertSame($token, $credentials->getToken());
    }

    public function testCreateWithInvalidCredentials(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value for "credentials" option');

        new GoSms(['credentials' => 'foo:bar']); // @phpstan-ignore-line
    }

    public function testChildren(): void
    {
        $mockClient = new Client();
        $goSms = new GoSms(
            [
                'credentials' => new TokenCredentials(new Token('foo', time())),
                'client' => new GoSmsClient($mockClient),
            ],
        );

        $goSms->auth()->request('GET');
        self::assertSame('/oauth/v2/token', $mockClient->getLastRequest()->getUri()->getPath());
        $goSms->organization()->request('GET');
        self::assertSame('/api/v1', $mockClient->getLastRequest()->getUri()->getPath());
        $goSms->messages()->request('GET');
        self::assertSame('/api/v1/messages', $mockClient->getLastRequest()->getUri()->getPath());
    }

    public function testUserAgent(): void
    {
        $mockClient = new Client();
        $goSms = new GoSms(
            [
                'credentials' => new TokenCredentials(new Token('foo', time())),
                'client' => new GoSmsClient($mockClient),
            ],
        );

        $goSms->request('GET');
        self::assertSame(
            'digitalcz/gosms:' . GoSms::VERSION . ' PHP:' . PHP_VERSION,
            $mockClient->getLastRequest()->getHeaderLine('User-Agent'),
        );

        $goSms->removeVersion('PHP');
        $goSms->request('GET');
        self::assertSame(
            'digitalcz/gosms:' . GoSms::VERSION,
            $mockClient->getLastRequest()->getHeaderLine('User-Agent'),
        );
    }

    public function testCreateWithApiBase(): void
    {
        $mockClient = new Client();
        $goSms = new GoSms(
            [
                'client' => new GoSmsClient($mockClient),
                'credentials' => new TokenCredentials(new Token('foo', time())),
                'api_base' => 'https://example.org/api',
            ],
        );
        $goSms->request('GET', '/foo');

        self::assertSame('https://example.org/api/foo', (string)$mockClient->getLastRequest()->getUri());
    }

    public function testCreateWithInvalidApiBase(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value for "api_base" option');

        new GoSms(['api_base' => ['https://example.org/api']]); // @phpstan-ignore-line
    }
}
