<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Delivery
{
    /**
     * @var bool
     */
    private $isDelivered = false;

    /**
     * @var int
     */
    private $smsCount = 0;

    /**
     * @var int
     */
    private $deliveredSmsCount = 0;

    /**
     * @var array<mixed>
     */
    private $recipients;

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
            $data['isDelivered'],
            $data['smsCount'],
            $data['deliveredSmsCount'],
            $data['recipients']
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
