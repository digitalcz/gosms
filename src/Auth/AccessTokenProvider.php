<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use Psr\SimpleCache\CacheInterface;

class AccessTokenProvider implements AccessTokenProviderInterface
{
    protected CacheInterface $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getAccessToken(ClientCredentials $credentials): ?AccessToken
    {
        $accessToken = $this->cache->get($credentials->getClientId());

        if (!is_array($accessToken)) {
            return null;
        }

        return AccessToken::fromArray($accessToken);
    }

    public function setAccessToken(ClientCredentials $credentials, AccessToken $accessToken): void
    {
        $this->cache->set($credentials->getClientId(), $accessToken->toArray(), $accessToken->getExpiresIn());
    }
}
