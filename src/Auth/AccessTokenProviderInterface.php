<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\ClientCredentials;

interface AccessTokenProviderInterface
{
    public function getAccessToken(ClientCredentials $credentials): ?AccessToken;

    public function setAccessToken(ClientCredentials $credentials, AccessToken $accessToken): void;
}
