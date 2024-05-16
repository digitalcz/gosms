<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class DetailMessageTest extends TestCase
{
    public function testConstruct(): void
    {
        $message = new DetailMessage\Message("Hello World!", ["Hello World!"]);

        $recipients = new DetailMessage\Recipients(
            [
                "+420111222333",
                "+420111222444",
            ],
            [
                "+420111222555",
            ],
            [
                "+420111222666",
            ],
        );

        $stats = new DetailMessage\Stats(
            0.739,
            false,
            1,
            1,
            1,
            new DetailMessage\NumberTypes(
                1,
                0,
                0,
                0,
                0,
                0,
                0,
            ),
        );

        $sendingInfo = new DetailMessage\SendingInfo(
            "IN_PROGRESS|FAILED|SENT",
            new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
            new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
            new DateTimeImmutable("2014-12-24T21:23:01+02:00"),
        );

        $delivery = new DetailMessage\Delivery(
            false,
            3,
            1,
            [
                "delivered" => [
                    "+420111222333" => "2014-12-24T21:23:00+02:00",
                ],
                "undelivered" => [
                    "+420111222444" => "2014-12-24T21:24:00+02:00",
                ],
                "delivering" => [
                    "+420111222555" => [
                        "deliveredCount" => 0,
                        "undeliveredCount" => 0,
                        "deliveringCount" => 1,
                    ],
                ],
            ],
        );

        $reply = new DetailMessage\Reply(true, 0);
        $links = new DetailMessage\Links("api/v1/messages/1", "api/v1/messages/1/replies");

        $object = new DetailMessage("SMS", $message, $recipients, 1, $stats, $sendingInfo, $delivery, $reply, $links);

        self::assertSame('SMS', $object->getMessageType());
        self::assertSame($message, $object->getMessage());
        self::assertSame($recipients, $object->getRecipients());
        self::assertSame(1, $object->getChannel());
        self::assertSame($stats, $object->getStats());
        self::assertSame($sendingInfo, $object->getSendingInfo());
        self::assertSame($delivery, $object->getDelivery());
        self::assertSame($reply, $object->getReply());
        self::assertSame($links, $object->getLinks());
    }

    public function testToArray(): void  // phpcs:ignore
    {
        $message = new DetailMessage\Message("Hello World!", ["Hello World!"]);

        $recipients = new DetailMessage\Recipients(
            [
                "+420111222333",
                "+420111222444",
            ],
            [
                "+420111222555",
            ],
            [
                "+420111222666",
            ],
        );

        $stats = new DetailMessage\Stats(
            0.739,
            false,
            1,
            1,
            1,
            new DetailMessage\NumberTypes(
                1,
                0,
                0,
                0,
                0,
                0,
                0,
            ),
        );

        $sendingInfo = new DetailMessage\SendingInfo(
            "IN_PROGRESS|FAILED|SENT",
            new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
            new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
            new DateTimeImmutable("2014-12-24T21:23:01+02:00"),
        );

        $delivery = new DetailMessage\Delivery(
            false,
            3,
            1,
            [
                "delivered" => [
                    "+420111222333" => "2014-12-24T21:23:00+02:00",
                ],
                "undelivered" => [
                    "+420111222444" => "2014-12-24T21:24:00+02:00",
                ],
                "delivering" => [
                    "+420111222555" => [
                        "deliveredCount" => 0,
                        "undeliveredCount" => 0,
                        "deliveringCount" => 1,
                    ],
                ],
            ],
        );

        $reply = new DetailMessage\Reply(true, 0);
        $links = new DetailMessage\Links("api/v1/messages/1", "api/v1/messages/1/replies");

        $object = new DetailMessage("SMS", $message, $recipients, 1, $stats, $sendingInfo, $delivery, $reply, $links);

        self::assertSame(
            [
                'messageType' => 'SMS',
                'message' => [
                    'fulltext' => "Hello World!",
                    'parts' => ["Hello World!"],
                ],
                'recipients' => [
                    'sent' => [
                        "+420111222333",
                        "+420111222444",
                    ],
                    'notSent' => [
                        "+420111222555",
                    ],
                    'invalid' => [
                        "+420111222666",
                    ],
                ],
                'channel' => 1,
                'stats' => [
                    'price' => 0.739,
                    'hasDiacritics' => false,
                    'smsCount' => 1,
                    'messagePartsCount' => 1,
                    'recipientsCount' => 1,
                    'numberTypes' => [
                        'czMobile' => 1,
                        'czOther' => 0,
                        'sk' => 0,
                        'pl' => 0,
                        'hu' => 0,
                        'ro' => 0,
                        'other' => 0,
                    ],
                ],
                'sendingInfo' => [
                    'status' => "IN_PROGRESS|FAILED|SENT",
                    'expectedSendStart' => "2014-12-24T21:23:00+02:00",
                    'sentStart' => "2014-12-24T21:23:00+02:00",
                    'sentFinish' => "2014-12-24T21:23:01+02:00",
                ],
                'delivery' => [
                    'isDelivered' => false,
                    'smsCount' => 3,
                    'deliveredSmsCount' => 1,
                    'recipients' => [
                        "delivered" => [
                            "+420111222333" => "2014-12-24T21:23:00+02:00",
                        ],
                        "undelivered" => [
                            "+420111222444" => "2014-12-24T21:24:00+02:00",
                        ],
                        "delivering" => [
                            "+420111222555" => [
                                "deliveredCount" => 0,
                                "undeliveredCount" => 0,
                                "deliveringCount" => 1,
                            ],
                        ],
                    ],
                ],
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 0,
                ],
                'links' => [
                    'self' => 'api/v1/messages/1',
                    'replies' => 'api/v1/messages/1/replies',
                ],
            ],
            $object->toArray(),
        );
    }

    public function testFromArray(): void  // phpcs:ignore
    {
        $detailOrganization = DetailMessage::fromArray(
            [
                'messageType' => 'SMS',
                'message' => [
                    'fulltext' => "Hello World!",
                    'parts' => ["Hello World!"],
                ],
                'recipients' => [
                    'sent' => [
                        "+420111222333",
                        "+420111222444",
                    ],
                    'notSent' => [
                        "+420111222555",
                    ],
                    'invalid' => [
                        "+420111222666",
                    ],
                ],
                'channel' => 1,
                'stats' => [
                    'price' => 0.739,
                    'hasDiacritics' => false,
                    'smsCount' => 1,
                    'messagePartsCount' => 1,
                    'recipientsCount' => 1,
                    'numberTypes' => [
                        'czMobile' => 1,
                        'czOther' => 0,
                        'sk' => 0,
                        'pl' => 0,
                        'hu' => 0,
                        'ro' => 0,
                        'other' => 0,
                    ],
                ],
                'sendingInfo' => [
                    'status' => "IN_PROGRESS|FAILED|SENT",
                    'expectedSendStart' => "2014-12-24T21:23:00+02:00",
                    'sentStart' => "2014-12-24T21:23:00+02:00",
                    'sentFinish' => "2014-12-24T21:23:01+02:00",
                ],
                'delivery' => [
                    'isDelivered' => false,
                    'smsCount' => 3,
                    'deliveredSmsCount' => 1,
                    'recipients' => [
                        "delivered" => [
                            "+420111222333" => "2014-12-24T21:23:00+02:00",
                        ],
                        "undelivered" => [
                            "+420111222444" => "2014-12-24T21:24:00+02:00",
                        ],
                        "delivering" => [
                            "+420111222555" => [
                                "deliveredCount" => 0,
                                "undeliveredCount" => 0,
                                "deliveringCount" => 1,
                            ],
                        ],
                    ],
                ],
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 0,
                ],
                'links' => [
                    'self' => 'api/v1/messages/1',
                    'replies' => 'api/v1/messages/1/replies',
                ],
            ],
        );

        self::assertSame(
            [
                'messageType' => 'SMS',
                'message' => [
                    'fulltext' => "Hello World!",
                    'parts' => ["Hello World!"],
                ],
                'recipients' => [
                    'sent' => [
                        "+420111222333",
                        "+420111222444",
                    ],
                    'notSent' => [
                        "+420111222555",
                    ],
                    'invalid' => [
                        "+420111222666",
                    ],
                ],
                'channel' => 1,
                'stats' => [
                    'price' => 0.739,
                    'hasDiacritics' => false,
                    'smsCount' => 1,
                    'messagePartsCount' => 1,
                    'recipientsCount' => 1,
                    'numberTypes' => [
                        'czMobile' => 1,
                        'czOther' => 0,
                        'sk' => 0,
                        'pl' => 0,
                        'hu' => 0,
                        'ro' => 0,
                        'other' => 0,
                    ],
                ],
                'sendingInfo' => [
                    'status' => "IN_PROGRESS|FAILED|SENT",
                    'expectedSendStart' => "2014-12-24T21:23:00+02:00",
                    'sentStart' => "2014-12-24T21:23:00+02:00",
                    'sentFinish' => "2014-12-24T21:23:01+02:00",
                ],
                'delivery' => [
                    'isDelivered' => false,
                    'smsCount' => 3,
                    'deliveredSmsCount' => 1,
                    'recipients' => [
                        "delivered" => [
                            "+420111222333" => "2014-12-24T21:23:00+02:00",
                        ],
                        "undelivered" => [
                            "+420111222444" => "2014-12-24T21:24:00+02:00",
                        ],
                        "delivering" => [
                            "+420111222555" => [
                                "deliveredCount" => 0,
                                "undeliveredCount" => 0,
                                "deliveringCount" => 1,
                            ],
                        ],
                    ],
                ],
                'reply' => [
                    'hasReplies' => true,
                    'repliesCount' => 0,
                ],
                'links' => [
                    'self' => 'api/v1/messages/1',
                    'replies' => 'api/v1/messages/1/replies',
                ],
            ],
            $detailOrganization->toArray(),
        );
    }
}
