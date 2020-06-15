<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use PHPUnit\Framework\TestCase;

class AccessTokenTest extends TestCase
{
    public function testConstruct(): void
    {
        $accessToken = new AccessToken('AccessTokenIU78JO', 3600, 'bearer', 'user');

        self::assertSame('AccessTokenIU78JO', $accessToken->getAccessToken());
        self::assertSame(3600, $accessToken->getExpiresIn());
        self::assertSame('bearer', $accessToken->getTokenType());
        self::assertSame('user', $accessToken->getScope());
    }

    public function testFromArray(): void
    {
        $accessToken = AccessToken::fromArray(
            [
                'access_token' => 'AccessTokenIU78JO',
                'expires_in' => 3600,
                'token_type' => 'bearer',
                'scope' => 'user',
            ]
        );

        self::assertSame('AccessTokenIU78JO', $accessToken->getAccessToken());
        self::assertSame(3600, $accessToken->getExpiresIn());
        self::assertSame('bearer', $accessToken->getTokenType());
        self::assertSame('user', $accessToken->getScope());
    }

    public function testToArray(): void
    {
        $array = [
            'access_token' => 'AccessTokenIU78JO',
            'expires_in' => 3600,
            'token_type' => 'bearer',
            'scope' => 'user',
        ];

        $accessToken = AccessToken::fromArray($array);

        self::assertSame($array, $accessToken->toArray());
    }
}
