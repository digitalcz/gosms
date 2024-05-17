<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class Channel extends BaseResource
{
    public int $id;
    public string $name;
    public string $sourceNumber;
}
