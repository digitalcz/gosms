<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

use DigitalCz\GoSms\Exception\RuntimeException;
use DigitalCz\GoSms\GoSmsClient;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;

/**
 * @covers \DigitalCz\GoSms\Resource\Collection
 */
final class CollectionTest extends TestCase
{
    public function testGetResponseNotFromApi(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);
        $this->expectException(RuntimeException::class);
        $collection->getResponse();
    }

    public function testGetResponseFromApi(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);
        $collection->setResponse($expectedResponse);

        self::assertSame($expectedResponse, $collection->getResponse());
    }

    public function testGetResult(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $dr0 = new DummyResource(DummyResource::EXAMPLE); // phpcs:ignore
        $dr1 = new DummyResource(DummyResource::EXAMPLE); // phpcs:ignore
        $dr2 = new DummyResource(DummyResource::EXAMPLE); // phpcs:ignore

        $collection = new Collection($parsedResponse, DummyResource::class);
        $collectionResults = $collection->getResult();

        self::assertSame($collectionResults[0]->toArray(), $dr0->toArray());
        self::assertSame($collectionResults[1]->toArray(), $dr1->toArray());
        self::assertSame($collectionResults[2]->toArray(), $dr2->toArray());
    }

    public function testToArray(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);

        self::assertSame(DummyResource::COLLECTION_EXAMPLE, $collection->toArray());
    }

    public function testJsonSerialize(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);

        self::assertSame(DummyResource::COLLECTION_EXAMPLE, $collection->jsonSerialize());
    }

    public function testGetLink(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);
        $this->expectException(RuntimeException::class);
        $collection->link();
    }

    public function testId(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);
        $this->expectException(RuntimeException::class);
        $collection->id();
    }

    public function testGetResourceClass(): void
    {
        $expectedResponse = new Response(200, [], GoSmsClient::jsonEncode(DummyResource::COLLECTION_EXAMPLE));

        $parsedResponse = GoSmsClient::parseResponse($expectedResponse);
        self::assertNotNull($parsedResponse);

        $collection = new Collection($parsedResponse, DummyResource::class);
        self::assertSame(DummyResource::class, $collection->getResourceClass());
    }
}
