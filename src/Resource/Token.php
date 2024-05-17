<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class Token extends BaseResource
{
    public string $accessToken;
    public int $expiresIn;
    public string $tokenType;
    public string $scope;
}
