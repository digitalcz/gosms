<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;
use LogicException;
use Psr\SimpleCache\CacheInterface;

/**
 * Decorator to cache Credentials with PSR-16 CacheInterface
 */
final class CachedCredentials implements Credentials
{
    private const PREFIX = 'GOSMS_tok_';

    private Credentials $inner;
    private CacheInterface $cache;

    public function __construct(Credentials $inner, CacheInterface $cache)
    {
        if ($inner instanceof self) {
            throw new LogicException('Prevent double decoration');
        }

        $this->inner = $inner;
        $this->cache = $cache;
    }

    public function getHash(): string
    {
        return self::PREFIX . $this->inner->getHash();
    }

    public function provide(GoSms $goSms): Token
    {
        $key = $this->getHash();

        if ($this->cache->has($key)) {
            $token = $this->cache->get($key);

            if ($token instanceof Token) {
                return $token;
            }
        }

        $token = $this->inner->provide($goSms);

        $this->cache->set($key, $token, $token->getTtl());

        return $token;
    }

    public function getInner(): Credentials
    {
        return $this->inner;
    }
}
