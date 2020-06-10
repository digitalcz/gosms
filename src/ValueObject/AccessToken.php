<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DateTimeImmutable;

class AccessToken
{
    /**
     * @var string
     */
    private $accessToken;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var DateTimeImmutable
     */
    private $expiresAt;

    /**
     * @var string
     */
    private $tokenType;

    /**
     * @var string
     */
    private $scope;

    public function __construct(string $accessToken, int $expiresIn, string $tokenType, string $scope)
    {
        $this->accessToken = $accessToken;
        $this->expiresIn = $expiresIn;
        $this->tokenType = $tokenType;
        $this->scope = $scope;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['access_token'],
            $data['expires_in'],
            $data['token_type'],
            $data['scope']
        );
    }

    /**
     * @return mixed[]
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

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt->modify('-5 minutes')->getTimestamp() < time();
    }

    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    public function setExpiresIn(int $expiresIn): void
    {
        $this->expiresIn = $expiresIn;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getTokenType(): string
    {
        return $this->tokenType;
    }

    public function setTokenType(string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    public function getScope(): string
    {
        return $this->scope;
    }

    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }
}
