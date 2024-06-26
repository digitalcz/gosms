<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;

/**
 * @covers \DigitalCz\GoSms\Auth\CachedCredentials
 */
class CachedCredentialsTest extends TestCase
{
    public function testHash(): void
    {
        $credentials = new TokenCredentials(new Token('token', 123));
        $cache = new Psr16Cache(new ArrayAdapter());
        $cachedCredentials = new CachedCredentials($credentials, $cache);

        self::assertSame($credentials, $cachedCredentials->getInner());
        self::assertSame('GOSMS_tok_1fc34072660678ab6395a990ca908258', $cachedCredentials->getHash());
    }

    public function testProvide(): void
    {
        $credentials = $this->createMock(Credentials::class);
        $credentials
            ->expects(self::once())
            ->method('provide')
            ->willReturn(new Token('token', time() + 300));

        $goSms = new GoSms();

        $cache = new Psr16Cache(new ArrayAdapter());
        $cachedCredentials = new CachedCredentials($credentials, $cache);

        $cachedCredentials->provide($goSms);
        $cachedCredentials->provide($goSms);
        $cachedCredentials->provide($goSms);
        $cachedCredentials->provide($goSms);
    }

    public function testPreventDoubleDecoration(): void
    {
        $credentials = new TokenCredentials(new Token('token', 123));
        $cache = new Psr16Cache(new ArrayAdapter());
        $cachedCredentials = new CachedCredentials($credentials, $cache);

        $this->expectException(LogicException::class);
        new CachedCredentials($cachedCredentials, $cache);
    }
}
