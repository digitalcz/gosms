<?php

declare(strict_types=1);

namespace DigitalCz\GoSms;

use DigitalCz\GoSms\Auth\AccessTokenProviderInterface;
use DigitalCz\GoSms\Http\Client;
use DigitalCz\GoSms\Request\RequestFactory;
use DigitalCz\GoSms\Response\ResponseObjectResolver;
use DigitalCz\GoSms\Response\ResponseResolverInterface;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use DigitalCz\GoSms\ValueObject\DetailMessage;
use DigitalCz\GoSms\ValueObject\DetailOrganization;
use DigitalCz\GoSms\ValueObject\RepliesMessage;
use DigitalCz\GoSms\ValueObject\SendMessage;
use DigitalCz\GoSms\ValueObject\SentMessage;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

final class GoSms
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var ResponseResolverInterface
     */
    private $responseObjectFactory;

    public function __construct(
        string $clientId,
        string $clientSecret,
        AccessTokenProviderInterface $accessTokenProvider,
        ClientInterface $httpClient = null,
        RequestFactoryInterface $httpRequestFactory = null,
        StreamFactoryInterface $httpStreamFactory = null,
        ResponseResolverInterface $responseResolver = null
    ) {
        $httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $httpRequestFactory = $httpRequestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $httpStreamFactory = $httpStreamFactory ?? Psr17FactoryDiscovery::findStreamFactory();

        $this->requestFactory = new RequestFactory($httpRequestFactory, $httpStreamFactory);
        $this->responseObjectFactory = $responseResolver ?? new ResponseObjectResolver();

        $this->client = new Client(
            new ClientCredentials($clientId, $clientSecret),
            $httpClient,
            $accessTokenProvider,
            $this->requestFactory,
            $this->responseObjectFactory
        );
    }

    public function getDetailOrganization(): DetailOrganization
    {
        $request = $this->requestFactory->requestDetailOrganization();
        $response = $this->client->request($request);

        return $this->responseObjectFactory->resolveDetailOrganization($response);
    }

    public function sendMessage(SendMessage $message): SentMessage
    {
        $request = $this->requestFactory->requestSendMessage($message);
        $response = $this->client->request($request);

        return $this->responseObjectFactory->resolveSendMessage($response);
    }

    public function detailMessage(int $messageId): DetailMessage
    {
        $request = $this->requestFactory->requestDetailMessage($messageId);
        $response = $this->client->request($request);

        return $this->responseObjectFactory->resolveDetailMessage($response);
    }

    public function deleteMessage(int $messageId): void
    {
        $request = $this->requestFactory->requestDeleteMessage($messageId);
        $this->client->request($request);
    }

    public function repliesMessage(int $messageId): RepliesMessage
    {
        $request = $this->requestFactory->requestRepliesMessage($messageId);
        $response = $this->client->request($request);

        return $this->responseObjectFactory->resolveRepliesMessage($response);
    }
}
