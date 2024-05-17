<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageStats extends BaseResource
{
    public float $price;
    public string $currency;
    public bool $hasDiacritics;
    public int $smsCount;
    public int $messagePartsCount;
    public int $recipientsCount;
    public MessageNumberTypes $numberTypes;
}
