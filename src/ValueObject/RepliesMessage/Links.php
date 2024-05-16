<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject\RepliesMessage;

class Links
{
    private string $message;

    private string $replies;

    public function __construct(string $message, string $replies)
    {
        $this->message = $message;
        $this->replies = $replies;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): Links
    {
        return new self($data['message'], $data['replies']); // @phpstan-ignore-line
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'replies' => $this->getReplies(),
        ];
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getReplies(): string
    {
        return $this->replies;
    }
}
