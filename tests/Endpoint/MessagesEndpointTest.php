<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

/**
 * @covers \DigitalCz\GoSms\Endpoint\MessagesEndpoint
 */
class MessagesEndpointTest extends EndpointTestCase
{
    public function testCreate(): void
    {
        self::goSms()->messages()->create(['foo' => 'bar']);
        self::assertLastRequest('POST', '/api/v1/messages', ['foo' => 'bar']);
    }

    public function testCreateTest(): void
    {
        self::goSms()->messages()->test(['foo' => 'bar']);
        self::assertLastRequest('POST', '/api/v1/messages/test', ['foo' => 'bar']);
    }

    public function testGet(): void
    {
        self::goSms()->messages()->get('foo');
        self::assertLastRequest('GET', '/api/v1/messages/foo');
    }

    public function testDelete(): void
    {
        self::goSms()->messages()->delete('foo');
        self::assertLastRequest('DELETE', '/api/v1/messages/foo');
    }

    public function testReplies(): void
    {
        self::goSms()->messages()->replies('foo');
        self::assertLastRequest('GET', '/api/v1/messages/foo/replies');
    }
}
