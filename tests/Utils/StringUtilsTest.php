<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Utils;

use DigitalCz\GoSms\Exception\RuntimeException;
use PHPUnit\Framework\TestCase;

class StringUtilsTest extends TestCase
{
    public function testResolveIdFromLink(): void
    {
        $this->assertEquals(666, StringUtils::resolveIdFromLink('api/v1/messages/666'));
    }

    public function testException1(): void
    {
        $this->expectException(RuntimeException::class);

        StringUtils::resolveIdFromLink('api/v1/messages/gosms');
    }

    public function testException2(): void
    {
        $this->expectException(RuntimeException::class);

        StringUtils::resolveIdFromLink('gosms');
    }
}
