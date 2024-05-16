<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DateTimeImmutable;

class SendMessage
{
    private string $message;

    /**
     * @var array<mixed>
     */
    private array $recipients = [];

    private int $channel;

    private ?DateTimeImmutable $expectedSendStart = null;

    /**
     * @param array<mixed> $recipients
     */
    public function __construct(string $message, array $recipients, int $channel)
    {
        $this->message = $message;
        $this->recipients = $recipients;
        $this->channel = $channel;
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        $data = [
            'message' => $this->message,
            'recipients' => $this->recipients,
            'channel' => $this->channel,
        ];

        if ($this->expectedSendStart !== null) {
            $data['expectedSendStart'] = $this->expectedSendStart->format('c');
        }

        return $data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<mixed>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getChannel(): int
    {
        return $this->channel;
    }

    public function getExpectedSendStart(): ?DateTimeImmutable
    {
        return $this->expectedSendStart;
    }

    public function setExpectedSendStart(?DateTimeImmutable $expectedSendStart): void
    {
        $this->expectedSendStart = $expectedSendStart;
    }
}
