<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

use DateTimeImmutable;

class SendingInfo
{
    private string $status;

    private DateTimeImmutable $expectedSendStart;

    private DateTimeImmutable $sentStart;

    private DateTimeImmutable $sentFinish;

    public function __construct(
        string $status,
        DateTimeImmutable $expectedSendStart,
        DateTimeImmutable $sentStart,
        DateTimeImmutable $sentFinish,
    ) {
        $this->status = $status;
        $this->expectedSendStart = $expectedSendStart;
        $this->sentStart = $sentStart;
        $this->sentFinish = $sentFinish;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): SendingInfo
    {
        return new self(
            $data['status'], // @phpstan-ignore-line
            new DateTimeImmutable($data['expectedSendStart']), // @phpstan-ignore-line
            new DateTimeImmutable($data['sentStart']), // @phpstan-ignore-line
            new DateTimeImmutable($data['sentFinish']), // @phpstan-ignore-line
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'status' => $this->getStatus(),
            'expectedSendStart' => $this->getExpectedSendStart()->format('c'),
            'sentStart' => $this->getSentStart()->format('c'),
            'sentFinish' => $this->getSentFinish()->format('c'),
        ];
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getExpectedSendStart(): DateTimeImmutable
    {
        return $this->expectedSendStart;
    }

    public function getSentStart(): DateTimeImmutable
    {
        return $this->sentStart;
    }

    public function getSentFinish(): DateTimeImmutable
    {
        return $this->sentFinish;
    }
}
