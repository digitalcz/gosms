<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DigitalCz\GoSms\ValueObject\DetailMessage\Delivery;
use DigitalCz\GoSms\ValueObject\DetailMessage\Links;
use DigitalCz\GoSms\ValueObject\DetailMessage\Message;
use DigitalCz\GoSms\ValueObject\DetailMessage\Recipients;
use DigitalCz\GoSms\ValueObject\DetailMessage\Reply;
use DigitalCz\GoSms\ValueObject\DetailMessage\SendingInfo;
use DigitalCz\GoSms\ValueObject\DetailMessage\Stats;

class DetailMessage
{
    /**
     * @var string
     */
    private $messageType;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var Recipients
     */
    private $recipients;

    /**
     * @var int
     */
    private $channel;

    /**
     * @var Stats
     */
    private $stats;

    /**
     * @var SendingInfo
     */
    private $sendingInfo;

    /**
     * @var Delivery
     */
    private $delivery;

    /**
     * @var Reply
     */
    private $reply;

    /**
     * @var Links
     */
    private $links;

    public function __construct(
        string $messageType,
        Message $message,
        Recipients $recipients,
        int $channel,
        Stats $stats,
        SendingInfo $sendingInfo,
        Delivery $delivery,
        Reply $reply,
        Links $links
    ) {
        $this->messageType = $messageType;
        $this->message = $message;
        $this->recipients = $recipients;
        $this->channel = $channel;
        $this->stats = $stats;
        $this->sendingInfo = $sendingInfo;
        $this->delivery = $delivery;
        $this->reply = $reply;
        $this->links = $links;
    }

    /**
     * @param array<mixed> $data
     */
    public static function fromArray(array $data): DetailMessage
    {
        return new self(
            $data['messageType'],
            Message::fromArray($data['message']),
            Recipients::fromArray($data['recipients']),
            $data['channel'],
            Stats::fromArray($data['stats']),
            SendingInfo::fromArray($data['sendingInfo']),
            Delivery::fromArray($data['delivery']),
            Reply::fromArray($data['reply']),
            Links::fromArray($data['links'])
        );
    }

    /**
     * @return array<mixed>
     */
    public function toArray(): array
    {
        return [
            'messageType' => $this->getMessageType(),
            'message' => $this->getMessage()->toArray(),
            'recipients' => $this->getRecipients()->toArray(),
            'channel' => $this->getChannel(),
            'stats' => $this->getStats()->toArray(),
            'sendingInfo' => $this->getSendingInfo()->toArray(),
            'delivery' => $this->getDelivery()->toArray(),
            'reply' => $this->getReply()->toArray(),
            'links' => $this->getLinks()->toArray(),
        ];
    }


    public function getMessageType(): string
    {
        return $this->messageType;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function getRecipients(): Recipients
    {
        return $this->recipients;
    }

    public function getChannel(): int
    {
        return $this->channel;
    }

    public function getStats(): Stats
    {
        return $this->stats;
    }

    public function getSendingInfo(): SendingInfo
    {
        return $this->sendingInfo;
    }

    public function getDelivery(): Delivery
    {
        return $this->delivery;
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
