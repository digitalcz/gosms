<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\Dummy\Auth\InMemoryCache;
use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use PHPUnit\Framework\TestCase;

class AccessTokenProviderTest extends TestCase
{
    public function testNotAccessTokenInCache(): void
    {
        $credentials = new ClientCredentials('clientId', 'clientSecret');

        $provider = new AccessTokenProvider(new InMemoryCache());

        $this->assertEquals(null, $provider->getAccessToken($credentials));
    }

    public function testAccessTokenICache(): void
    {
        $credentials = new ClientCredentials('clientId', 'clientSecret');

        $cache = new InMemoryCache();
        $provider = new AccessTokenProvider($cache);

        $contents = file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json');
        $data = json_decode($contents !== false ? $contents : '', true);
        $token = AccessToken::fromArray($data); // @phpstan-ignore-line

        $cache->set('clientId', $data);

        $this->assertEquals($token, $provider->getAccessToken($credentials));
    }

    public function testSetAccessTokenToCache(): void
    {
        $credentials = new ClientCredentials('clientId', 'clientSecret');

        $cache = new InMemoryCache();
        $provider = new AccessTokenProvider($cache);

        $contents = file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json');
        $data = json_decode($contents !== false ? $contents : '', true);
        $token = AccessToken::fromArray($data); // @phpstan-ignore-line

        $provider->setAccessToken($credentials, $token);

        $this->assertEquals($data, $cache->get($credentials->getClientId()));

        $tokenFromCache = $provider->getAccessToken($credentials);

        $this->assertEquals($tokenFromCache, $token);
    }
}
