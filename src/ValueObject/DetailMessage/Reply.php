<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\DetailMessage;

class Reply
{
    private bool $hasReplies = false;

    private int $repliesCount = 0;

    public function __construct(bool $hasReplies, int $repliesCount)
    {
        $this->hasReplies = $hasReplies;
        $this->repliesCount = $repliesCount;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Reply
    {
        return new self($data['hasReplies'], $data['repliesCount']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'hasReplies' => $this->isHasReplies(),
            'repliesCount' => $this->getRepliesCount(),
        ];
    }

    public function isHasReplies(): bool
    {
        return $this->hasReplies;
    }

    public function getRepliesCount(): int
    {
        return $this->repliesCount;
    }
}
