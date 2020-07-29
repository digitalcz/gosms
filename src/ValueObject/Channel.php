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

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'sourceNumber' => $this->getSourceNumber(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSourceNumber(): string
    {
        return $this->sourceNumber;
    }
}
