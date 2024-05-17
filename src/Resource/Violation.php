<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class Violation extends BaseResource
{
    public string $propertyPath;

    public string $title;

    /** @var string[] */
    public array $parameters;

    public string $type;
}
