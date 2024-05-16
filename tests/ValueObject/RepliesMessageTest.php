<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DigitalCz\GoSms\ValueObject\RepliesMessage\Links;
use DigitalCz\GoSms\ValueObject\RepliesMessage\Reply;
use PHPUnit\Framework\TestCase;

class RepliesMessageTest extends TestCase
{
    public function testConstruct(): void
    {
        $reply = new Reply(true, 2, [
            [
                "id" => 1,
                "message" => "odpoved",
                "sourceNumber" => "+420799507467",
                "received" => "2016-05-04T21:23:00+02:00",
            ],
        ]);
        $links = new Links("api/v1/messages/1", "api/v1/messages/1/replies");

        $sendMessage = new RepliesMessage($reply, $links);

        self::assertSame($reply, $sendMessage->getReply());
        self::assertSame($links, $sendMessage->getLinks());
    }

    public function testToArray(): void
    {
        $reply = new Reply(true, 2, [
            [
                "id" => 1,
                "message" => "odpoved",
                "sourceNumber" => "+420799507467",
                "received" => "2016-05-04T21:23:00+02:00",
            ],
        ]);
        $links = new Links("api/v1/messages/1", "api/v1/messages/1/replies");

        $sendMessage = new RepliesMessage($reply, $links);

        self::assertSame(
            [
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 2,
                    'recipients' => [
                        [
                            "id" => 1,
                            "message" => "odpoved",
                            "sourceNumber" => "+420799507467",
                            "received" => "2016-05-04T21:23:00+02:00",
                        ],
                    ],
                ],
                'links' => [
                    'message' => "api/v1/messages/1",
                    'replies' => "api/v1/messages/1/replies",
                ],
            ],
            $sendMessage->toArray(),
        );
    }

    public function testFromArray(): void
    {
        $detailOrganization = RepliesMessage::fromArray(
            [
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 2,
                    'recipients' => [
                        [
                            "id" => 1,
                            "message" => "odpoved",
                            "sourceNumber" => "+420799507467",
                            "received" => "2016-05-04T21:23:00+02:00",
                        ],
                    ],
                ],
                'links' => [
                    'message' => "api/v1/messages/1",
                    'replies' => "api/v1/messages/1/replies",
                ],
            ],
        );

        self::assertSame(
            [
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 2,
                    'recipients' => [
                        [
                            "id" => 1,
                            "message" => "odpoved",
                            "sourceNumber" => "+420799507467",
                            "received" => "2016-05-04T21:23:00+02:00",
                        ],
                    ],
                ],
                'links' => [
                    'message' => "api/v1/messages/1",
                    'replies' => "api/v1/messages/1/replies",
                ],
            ],
            $detailOrganization->toArray(),
        );
    }
}
