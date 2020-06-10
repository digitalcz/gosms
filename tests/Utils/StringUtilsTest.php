<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Utils;

use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    public function testResolveIdFromLink() : void
    {
        $this->assertEquals(666, StringUtils::resolveIdFromLink('api/v1/messages/666'));
    }
}
