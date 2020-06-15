<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Response;

use DateTimeImmutable;
use DigitalCz\GoSms\Exception\RuntimeException;
use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\Channel;
use DigitalCz\GoSms\ValueObject\DetailMessage;
use DigitalCz\GoSms\ValueObject\DetailOrganization;
use DigitalCz\GoSms\ValueObject\RepliesMessage;
use DigitalCz\GoSms\ValueObject\SentMessage;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseObjectResolverTest extends TestCase
{
    public function testResolveAccessToken(): void
    {
        $dummyData = file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($dummyData);

        $token = new AccessToken('AccessTokenIU78JO', 3600, 'bearer', 'user');

        $responseResolver = new ResponseObjectResolver();

        $this->assertEquals($token, $responseResolver->resolveAccessToken($response));
    }

    public function testResolveDetailOrganization(): void
    {
        $dummyData = file_get_contents(__DIR__ . '/../Dummy/Responses/detail_organization.json');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($dummyData);

        $channel = new Channel(1, 'Název kanálu', 'GoSMS');
        $object = new DetailOrganization(23.09, [$channel]);

        $responseResolver = new ResponseObjectResolver();

        $this->assertEquals($object, $responseResolver->resolveDetailOrganization($response));
    }

    public function testResolveSendMessage(): void
    {
        $dummyData = file_get_contents(__DIR__ . '/../Dummy/Responses/sent_message.json');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($dummyData);

        $recipients = new SentMessage\Recipients(['Peter']);
        $object = new SentMessage($recipients, 'api/v1/messages/1');

        $responseResolver = new ResponseObjectResolver();

        $this->assertEquals($object, $responseResolver->resolveSendMessage($response));
    }

    public function testResolveDetailMessage(): void
    {
        $dummyData = file_get_contents(__DIR__ . '/../Dummy/Responses/detail_message.json');

        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($dummyData);

        $object = new DetailMessage(
            "SMS",
            new DetailMessage\Message("Hello World!", ["Hello World!"]),
            new DetailMessage\Recipients(
                [
                    "+420111222333",
                    "+420111222444"
                ],
                [
                    "+420111222555"
                ],
                [
                    "+420111222666"
                ]
            ),
            1,
            new DetailMessage\Stats(
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
                    0
                )
            ),
            new DetailMessage\SendingInfo(
                "IN_PROGRESS|FAILED|SENT",
                new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
                new DateTimeImmutable("2014-12-24T21:23:00+02:00"),
                new DateTimeImmutable("2014-12-24T21:23:01+02:00")
            ),
            new DetailMessage\Delivery(
                false,
                3,
                1,
                [
                    "delivered" => [
                        "+420111222333" => "2014-12-24T21:23:00+02:00"
                    ],
                    "undelivered" => [
                        "+420111222444" => "2014-12-24T21:24:00+02:00"
                    ],
                    "delivering" => [
                        "+420111222555" => [
                            "deliveredCount" => 0,
                            "undeliveredCount" => 0,
                            "deliveringCount" => 1
                        ]
                    ]
                ]
            ),
            new DetailMessage\Reply(true, 0),
            new DetailMessage\Links("api/v1/messages/1", "api/v1/messages/1/replies")
        );

        $responseResolver = new ResponseObjectResolver();

        $this->assertEquals($object, $responseResolver->resolveDetailMessage($response));
    }

    public function testResolveRepliesMessage(): void
    {
        $dummyData = file_get_contents(__DIR__ . '/../Dummy/Responses/replies_message.json');
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn($dummyData);

        $reply = new RepliesMessage\Reply(
            true,
            1,
            [
                "+420111222333" => [
                    [
                        "id" => 1,
                        "message" => "odpoved",
                        "sourceNumber" => "+420799507467",
                        "received" => "2016-05-04T21:23:00+02:00"
                    ]
                ]
            ]
        );
        $links = new RepliesMessage\Links(
            "api/v1/messages/1",
            "api/v1/messages/1/replies"
        );
        $object = new RepliesMessage($reply, $links);

        $responseResolver = new ResponseObjectResolver();

        $this->assertEquals($object, $responseResolver->resolveRepliesMessage($response));
    }

    public function testFailedParseBody(): void
    {
        $response = $this->createMock(ResponseInterface::class);
        $response->method('getBody')->willReturn('bad request');

        $responseResolver = new ResponseObjectResolver();

        $this->expectException(RuntimeException::class);

        $responseResolver->resolveDetailOrganization($response);
    }
}
