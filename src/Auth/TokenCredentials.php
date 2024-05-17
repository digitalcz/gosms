<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;

/**
 * Use this if you already have the auth Token
 */
final class TokenCredentials implements Credentials
{
    private Token $token;

    public function __construct(Token $token)
    {
        $this->token = $token;
    }

    public function getHash(): string
    {
        return md5($this->token->getToken() . $this->token->getExp());
    }

    public function provide(GoSms $goSms): Token
    {
        return $this->token;
    }

    public function getToken(): Token
    {
        return $this->token;
    }
}
