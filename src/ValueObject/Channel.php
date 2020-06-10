<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

class Channel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $sourceNumber;

    public function __construct(int $id, string $name, string $sourceNumber)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sourceNumber = $sourceNumber;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Channel
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['sourceNumber']
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSourceNumber(): string
    {
        return $this->sourceNumber;
    }

    public function setSourceNumber(string $sourceNumber): void
    {
        $this->sourceNumber = $sourceNumber;
    }
}
