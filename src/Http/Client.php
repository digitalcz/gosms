<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Http;

use DigitalCz\GoSms\Auth\AccessTokenProviderInterface;
use DigitalCz\GoSms\Exception\ClientNotSuccessException;
use DigitalCz\GoSms\Request\RequestFactory;
use DigitalCz\GoSms\Response\ResponseObjectFactory;
use DigitalCz\GoSms\ValueObject\ClientCredentials;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /**
     * @var ClientCredentials
     */
    protected $clientCredentials;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var AccessTokenProviderInterface
     */
    protected $tokenProvider;

    /**
     * @var RequestFactory
     */
    protected $requestFactory;

    /**
     * @var ResponseObjectFactory
     */
    protected $responseObjectFactory;

    public function __construct(
        ClientCredentials $clientCredentials,
        ClientInterface $httpClient,
        AccessTokenProviderInterface $tokenProvider,
        RequestFactory $requestFactory,
        ResponseObjectFactory $responseObjectFactory
    ) {
        $this->clientCredentials = $clientCredentials;
        $this->httpClient = $httpClient;
        $this->tokenProvider = $tokenProvider;
        $this->requestFactory = $requestFactory;
        $this->responseObjectFactory = $responseObjectFactory;
    }

    public function request(RequestInterface $request): ResponseInterface
    {
        $response = $this->doRequest($request);

        $this->checkResponse($response);

        return $response;
    }

    public function doRequest(RequestInterface $request): ResponseInterface
    {
        $accessToken = $this->tokenProvider->getAccessToken($this->clientCredentials);

        if ($accessToken === null) {
            $request = $this->requestFactory->requestAccessToken($this->clientCredentials);
            $response = $this->httpClient->sendRequest($request);

            $accessToken = $this->responseObjectFactory->createAccessToken($response);

            $this->tokenProvider->setAccessToken($this->clientCredentials, $accessToken);
        }

        $request = $request->withHeader('Authorization', 'Bearer ' . $accessToken->getAccessToken());

        return $this->httpClient->sendRequest($request);
    }

    protected function checkResponse(ResponseInterface $response): void
    {
        if (!in_array($response->getStatusCode(), [200, 201])) {
            throw new ClientNotSuccessException($response->getBody()->getContents(), $response->getStatusCode());
        }
    }
}
