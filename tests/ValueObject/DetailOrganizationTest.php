<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\ValueObject;

use PHPUnit\Framework\TestCase;

class DetailOrganizationTest extends TestCase
{
    public function testConstruct(): void
    {
        $channel = new Channel(1, 'Abc', '123');
        $detailOrganization = new DetailOrganization(100, [$channel]);

        self::assertSame(100.0, $detailOrganization->getCurrentCredit());
        self::assertSame([$channel], $detailOrganization->getChannels());
    }

    public function testToArray(): void
    {
        $channel = new Channel(1, 'Abc', '123');
        $detailOrganization = new DetailOrganization(100, [$channel]);

        self::assertSame(
            [
                'currentCredit' => 100.0,
                'channels' => [['id' => 1, 'name' => 'Abc', 'sourceNumber' => '123']],
            ],
            $detailOrganization->toArray(),
        );
    }

    public function testFromArray(): void
    {
        $detailOrganization = DetailOrganization::fromArray(
            [
                'currentCredit' => 100.0,
                'channels' => [['id' => 1, 'name' => 'Abc', 'sourceNumber' => '123']],
            ],
        );

        self::assertSame(
            [
                'currentCredit' => 100.0,
                'channels' => [['id' => 1, 'name' => 'Abc', 'sourceNumber' => '123']],
            ],
            $detailOrganization->toArray(),
        );
    }
}
