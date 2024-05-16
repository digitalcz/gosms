<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

class AccessToken
{
    private string $accessToken;

    private int $expiresIn;

    private string $tokenType;

    private string $scope;

    public function __construct(string $accessToken, int $expiresIn, string $tokenType, string $scope)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->tokenType = $tokenType;
        $this->scope = $scope;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['access_token'], // @phpstan-ignore-line
            $data['expires_in'], // @phpstan-ignore-line
            $data['token_type'], // @phpstan-ignore-line
            $data['scope'], // @phpstan-ignore-line
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'access_token' => $this->accessToken,
            'expires_in' => $this->expiresIn,
            'token_type' => $this->tokenType,
            'scope' => $this->scope,
        ];
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function getScope(): string
    {
        return $this->scope;
    }
}
