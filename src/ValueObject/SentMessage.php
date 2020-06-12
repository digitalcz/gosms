<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DigitalCz\GoSms\Utils\StringUtils;
use DigitalCz\GoSms\ValueObject\SentMessage\Recipients;

class SentMessage
{
    /**
     * @var Recipients
     */
    private $recipients;

    /**
     * @var string
     */
    private $link;

    public function __construct(Recipients $recipients, string $link)
    {
        $this->recipients = $recipients;
        $this->link = $link;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): SentMessage
    {
        return new self(
            Recipients::fromArray($data['recipients']),
            $data['link']
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'recipients' => $this->getRecipients()->toArray(),
            'link' => $this->getLink(),
        ];
    }

    public function getRecipients(): Recipients
    {
        return $this->recipients;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getMessageId(): int
    {
        return (int)StringUtils::resolveIdFromLink($this->getLink());
    }
}
