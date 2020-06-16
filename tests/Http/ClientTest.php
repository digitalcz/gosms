<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Http;

use DigitalCz\GoSms\Auth\AccessTokenProvider;
use DigitalCz\GoSms\Dummy\Auth\InMemoryCache;
use DigitalCz\GoSms\Exception\ClientNotSuccessException;
use DigitalCz\GoSms\Request\RequestFactory;
use DigitalCz\GoSms\Response\ResponseObjectResolver;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as HttpClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ClientTest extends TestCase
{
    public function testClient(): void
    {
        $credentials = new ClientCredentials('clientId', 'clientSecret');
        $httpClient = new HttpClient();
        $httpResponse = $this->createMock(ResponseInterface::class);
        $httpResponse
            ->method('getStatusCode')
            ->willReturn(200);
        $httpResponse
            ->expects(self::at(0))
            ->method('getBody')
            ->willReturn(file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json'));
        $httpResponse
            ->expects(self::at(1))
            ->method('getBody')
            ->willReturn(file_get_contents(__DIR__ . '/../Dummy/Responses/detail_organization.json'));
        $httpClient->addResponse($httpResponse);

        $cache = new InMemoryCache();
        $accessTokenProvider = new AccessTokenProvider($cache);

        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $responseResolver = new ResponseObjectResolver();

        $client = new Client(
            $credentials,
            $httpClient,
            $accessTokenProvider,
            $requestFactory,
            $responseResolver
        );

        $request = $requestFactory->requestDetailOrganization();

        $client->request($request);

        self::assertCount(2, $httpClient->getRequests());
        self::assertEquals(
            file_get_contents(__DIR__ . '/../Dummy/Responses/detail_organization.json'),
            (string)$httpResponse->getBody()
        );
        self::assertEquals('Bearer AccessTokenIU78JO', $httpClient->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testClientReturnException(): void
    {
        $credentials = new ClientCredentials('clientId', 'clientSecret');
        $httpClient = new HttpClient();
        $httpResponse = $this->createMock(ResponseInterface::class);
        $httpResponse
            ->method('getStatusCode')
            ->willReturn(400);
        $httpResponse
            ->expects(self::at(0))
            ->method('getBody')
            ->willReturn(file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json'));
        $httpResponse
            ->expects(self::at(1))
            ->method('getBody')
            ->willReturn(file_get_contents(__DIR__ . '/../Dummy/Responses/detail_organization.json'));
        $httpClient->addResponse($httpResponse);

        $cache = new InMemoryCache();

        $contents = file_get_contents(__DIR__ . '/../Dummy/Responses/access_token.json');
        $data = json_decode($contents !== false ? $contents : '', true);

        $cache->set('clientId', $data);
        $accessTokenProvider = new AccessTokenProvider($cache);

        $requestFactory = new RequestFactory(
            Psr17FactoryDiscovery::findRequestFactory(),
            Psr17FactoryDiscovery::findStreamFactory()
        );

        $responseResolver = new ResponseObjectResolver();

        $client = new Client(
            $credentials,
            $httpClient,
            $accessTokenProvider,
            $requestFactory,
            $responseResolver
        );

        $request = $requestFactory->requestDetailOrganization();

        self::expectException(ClientNotSuccessException::class);

        $client->request($request);
    }
}
