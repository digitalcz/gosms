<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

class Violations extends BaseResource
{
    public string $title;
    public string $detail;

    /** @var Collection<Violation> */
    public Collection $violations;

    /** @param mixed[] $result */
    public function __construct(array $result)
    {
        parent::__construct($result);

        $this->violations ??= new Collection([], Violation::class);
    }
}
