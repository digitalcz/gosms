<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\RepliesMessage;

class Reply
{
    private bool $hasReplies = false;

    private int $repliesCount = 0;

    /**
     * @var array<mixed>
     */
    private array $recipients = [];

    /**
     * @param array<mixed> $recipients
     */
    public function __construct(bool $hasReplies, int $repliesCount, array $recipients)
    {
        $this->hasReplies = $hasReplies;
        $this->repliesCount = $repliesCount;
        $this->recipients = $recipients;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Reply
    {
        return new self($data['hasReplies'], $data['repliesCount'], $data['recipients']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'hasReplies' => $this->isHasReplies(),
            'repliesCount' => $this->getRepliesCount(),
            'recipients' => $this->getRecipients(),
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

    /**
     * @return array<mixed>
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }
}
