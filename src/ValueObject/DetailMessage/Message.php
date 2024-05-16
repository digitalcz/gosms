<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Message
{
    private string $fulltext;

    /**
     * @var array<string>
     */
    private array $parts = [];

    /**
     * @param array<string> $parts
     */
    public function __construct(string $fulltext, array $parts)
    {
        $this->fulltext = $fulltext;
        $this->parts = $parts;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Message
    {
        return new self($data['fulltext'], $data['parts']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'fulltext' => $this->getFulltext(),
            'parts' => $this->getParts(),
        ];
    }

    public function getFulltext(): string
    {
        return $this->fulltext;
    }

    /**
     * @return array<mixed>
     */
    public function getParts(): array
    {
        return $this->parts;
    }
}
