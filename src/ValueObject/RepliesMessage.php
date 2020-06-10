<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DigitalCz\GoSms\ValueObject\RepliesMessage\Links;
use DigitalCz\GoSms\ValueObject\RepliesMessage\Reply;

class RepliesMessage
{
    /**
     * @var Reply
     */
    private $reply;

    /**
     * @var Links
     */
    private $links;

    public function __construct(Reply $reply, Links $links)
    {
        $this->reply = $reply;
        $this->links = $links;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): RepliesMessage
    {
        return new self(
            Reply::fromArray($data['reply']),
            Links::fromArray($data['links'])
        );
    }

    public function getReply(): Reply
    {
        return $this->reply;
    }

    public function getLinks(): Links
    {
        return $this->links;
    }
}
