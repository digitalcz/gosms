<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Request;

use DigitalCz\GoSms\Exception\RuntimeException;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use DigitalCz\GoSms\ValueObject\SendMessage;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class RequestFactoryTest extends TestCase
{
    public function testRequestAccessToken(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $credentials = new ClientCredentials('clientId', 'clientSecret');

        $request = $requestFactory->requestAccessToken($credentials);

        $expectedBody = sprintf(
            'client_id=%s&client_secret=%s&grant_type=client_credentials',
            $credentials->getClientId(),
            $credentials->getClientSecret()
        );

        self::assertEquals(RequestFactory::API_TOKEN, $request->getUri());
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals($expectedBody, $request->getBody());
        self::assertEquals('application/x-www-form-urlencoded', $request->getHeaderLine('Content-Type'));
    }

    public function testRequestDetailOrganization(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $request = $requestFactory->requestDetailOrganization();

        self::assertEquals(RequestFactory::API_DETAIL_ORGANIZATION, $request->getUri());
        self::assertEquals('GET', $request->getMethod());
    }

    public function testRequestSendMessage(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $message = new SendMessage('Hans, We need contribution!', ['+420775300500'], 1);

        $expectedBody = json_encode($message->toArray());

        $request = $requestFactory->requestSendMessage($message);

        self::assertEquals(RequestFactory::API_SEND_MESSAGE, $request->getUri());
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals($expectedBody, $request->getBody());
        self::assertEquals('application/json', $request->getHeaderLine('Content-Type'));
    }

    public function testRequestDetailMessage(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $request = $requestFactory->requestDetailMessage(123);

        self::assertEquals(sprintf(RequestFactory::API_DELETE_MESSAGE, 123), $request->getUri());
        self::assertEquals('GET', $request->getMethod());
    }

    public function testRequestDeleteMessage(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $request = $requestFactory->requestDeleteMessage(123);

        self::assertEquals(sprintf(RequestFactory::API_DELETE_MESSAGE, 123), $request->getUri());
        self::assertEquals('DELETE', $request->getMethod());
    }

    public function testRequestRepliesMessage(): void
    {
        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $request = $requestFactory->requestRepliesMessage(123);

        self::assertEquals(sprintf(RequestFactory::API_REPLIES_MESSAGE, 123), $request->getUri());
        self::assertEquals('GET', $request->getMethod());
    }
}
