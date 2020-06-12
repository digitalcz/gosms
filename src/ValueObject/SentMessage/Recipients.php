<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\SentMessage;

class Recipients
{
    /**
     * @var array<string>
     */
    private $invalid = [];

    /**
     * @param array<string> $invalid
     */
    public function __construct(array $invalid)
    {
        $this->invalid = $invalid;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Recipients
    {
        return new self(
            $data['invalid']
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'invalid' => $this->getInvalid()
        ];
    }

    /**
     * @return array<string>
     */
    public function getInvalid(): array
    {
        return $this->invalid;
    }
}
