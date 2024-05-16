<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Stats
{
    private float $price = 0.0;

    private bool $hasDiacritics = false;

    private int $smsCount = 0;

    private int $messagePartsCount = 0;

    private int $recipientsCount = 0;

    private NumberTypes $numberTypes;

    public function __construct(
        float $price,
        bool $hasDiacritics,
        int $smsCount,
        int $messagePartsCount,
        int $recipientsCount,
        NumberTypes $numberTypes,
    ) {
        $this->price = $price;
        $this->hasDiacritics = $hasDiacritics;
        $this->smsCount = $smsCount;
        $this->messagePartsCount = $messagePartsCount;
        $this->recipientsCount = $recipientsCount;
        $this->numberTypes = $numberTypes;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Stats
    {
        return new self(
            $data['price'], // @phpstan-ignore-line
            $data['hasDiacritics'], // @phpstan-ignore-line
            $data['smsCount'], // @phpstan-ignore-line
            $data['messagePartsCount'], // @phpstan-ignore-line
            $data['recipientsCount'], // @phpstan-ignore-line
            NumberTypes::fromArray($data['numberTypes']), // @phpstan-ignore-line
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'price' => $this->getPrice(),
            'hasDiacritics' => $this->isHasDiacritics(),
            'smsCount' => $this->getSmsCount(),
            'messagePartsCount' => $this->getMessagePartsCount(),
            'recipientsCount' => $this->getRecipientsCount(),
            'numberTypes' => $this->getNumberTypes()->toArray(),
        ];
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function isHasDiacritics(): bool
    {
        return $this->hasDiacritics;
    }

    public function getSmsCount(): int
    {
        return $this->smsCount;
    }

    public function getMessagePartsCount(): int
    {
        return $this->messagePartsCount;
    }

    public function getRecipientsCount(): int
    {
        return $this->recipientsCount;
    }

    public function getNumberTypes(): NumberTypes
    {
        return $this->numberTypes;
    }
}
