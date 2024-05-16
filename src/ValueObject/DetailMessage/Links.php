<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Links
{
    private string $self;

    private string $replies;

    public function __construct(string $self, string $replies)
    {
        $this->self = $self;
        $this->replies = $replies;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Links
    {
        return new self($data['self'], $data['replies']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'self' => $this->getSelf(),
            'replies' => $this->getReplies(),
        ];
    }

    public function getSelf(): string
    {
        return $this->self;
    }

    public function getReplies(): string
    {
        return $this->replies;
    }
}
