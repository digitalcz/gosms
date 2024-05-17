<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

/**
 * @covers \DigitalCz\GoSms\Endpoint\OrganizationEndpoint
 */
class OrganizationEndpointTest extends EndpointTestCase
{
    public function testDetail(): void
    {
        self::goSms()->organization()->detail();
        self::assertLastRequest('GET', '/api/v1');
    }
}
