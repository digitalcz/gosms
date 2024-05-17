<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class MessageMessage extends BaseResource
{
    public string $fulltext;

    /** @var array<int, string> */
    public array $parts = [];
}
