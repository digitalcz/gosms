<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Delivery
{
    private bool $isDelivered = false;

    private int $smsCount = 0;

    private int $deliveredSmsCount = 0;

    /**
     * @var array<mixed>
     */
    private array $recipients;

    /**
     * @param array<mixed> $recipients
     */
    public function __construct(bool $isDelivered, int $smsCount, int $deliveredSmsCount, array $recipients)
    {
        $this->isDelivered = $isDelivered;
        $this->smsCount = $smsCount;
        $this->deliveredSmsCount = $deliveredSmsCount;
        $this->recipients = $recipients;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Delivery
    {
        return new self(
            $data['isDelivered'], // @phpstan-ignore-line
            $data['smsCount'], // @phpstan-ignore-line
            $data['deliveredSmsCount'], // @phpstan-ignore-line
            $data['recipients'], // @phpstan-ignore-line
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'isDelivered' => $this->isDelivered(),
            'smsCount' => $this->getSmsCount(),
            'deliveredSmsCount' => $this->getDeliveredSmsCount(),
            'recipients' => $this->getRecipients(),
        ];
    }

    public function isDelivered(): bool
    {
        return $this->isDelivered;
    }

    public function getSmsCount(): int
    {
        return $this->smsCount;
    }

    public function getDeliveredSmsCount(): int
    {
        return $this->deliveredSmsCount;
    }

    /**
     * @return array<mixed>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
