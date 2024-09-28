<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;

/**
 * Credentials that are fetched with clientId/clientSecret
 */
final class ApiKeyCredentials implements Credentials
{
    private string $clientId;
    private string $clientSecret;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getHash(): string
    {
        return md5($this->clientId . $this->clientSecret);
    }

    public function provide(GoSms $goSms): Token
    {
        $body = [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'grant_type' => 'client_credentials',
        ];
        $token = $goSms->auth()->authorize($body);

        return new Token($token->accessToken, time() + $token->expiresIn);
    }
}
