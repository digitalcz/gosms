<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Stats
{
    /**
     * @var float
     */
    private $price = 0.0;

    /**
     * @var bool
     */
    private $hasDiacritics = false;

    /**
     * @var int
     */
    private $smsCount = 0;

    /**
     * @var int
     */
    private $messagePartsCount = 0;

    /**
     * @var int
     */
    private $recipientsCount = 0;

    /**
     * @var NumberTypes
     */
    private $numberTypes;

    public function __construct(
        float $price,
        bool $hasDiacritics,
        int $smsCount,
        int $messagePartsCount,
        int $recipientsCount,
        NumberTypes $numberTypes
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
            $data['price'],
            $data['hasDiacritics'],
            $data['smsCount'],
            $data['messagePartsCount'],
            $data['recipientsCount'],
            NumberTypes::fromArray($data['numberTypes'])
        );
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
