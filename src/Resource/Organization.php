<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class Organization extends BaseResource
{
    public float $currentCredit;
    public string $invoicingType;
    public string $currency;

    /** @var Collection<Channel> */
    public Collection $channels;
}
