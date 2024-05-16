<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Recipients
{
    /**
     * @var array<string>
     */
    private array $sent = [];

    /**
     * @var array<string>
     */
    private array $notSent = [];

    /**
     * @var array<string>
     */
    private array $invalid = [];

    /**
     * @param array<string> $sent
     * @param array<string> $notSent
     * @param array<string> $invalid
     */
    public function __construct(array $sent, array $notSent, array $invalid)
    {
        $this->sent = $sent;
        $this->notSent = $notSent;
        $this->invalid = $invalid;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Recipients
    {
        return new self($data['sent'], $data['notSent'], $data['invalid']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'sent' => $this->getSent(),
            'notSent' => $this->getNotSent(),
            'invalid' => $this->getInvalid(),
        ];
    }

    /**
     * @return array<string>
     */
    public function getSent(): array
    {
        return $this->sent;
    }

    /**
     * @return array<string>
     */
    public function getNotSent(): array
    {
        return $this->notSent;
    }

    /**
     * @return array<string>
     */
    public function getInvalid(): array
    {
        return $this->invalid;
    }
}
