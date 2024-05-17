<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

/**
 * @covers \DigitalCz\GoSms\Endpoint\AuthEndpoint
 */
class AuthEndpointTest extends EndpointTestCase
{
    public function testAuthorize(): void
    {
        self::goSms()->auth()->authorize(['foo' => 'bar']);
        self::assertLastRequestMethodIsPost();
        self::assertLastRequestPath('/oauth/v2/token');
    }
}
