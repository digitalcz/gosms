<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Request;

use DigitalCz\GoSms\ValueObject\ClientCredentials;
use DigitalCz\GoSms\ValueObject\SendMessage;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;
use RuntimeException;

class RequestFactory
{
    public const API_TOKEN = 'https://app.gosms.cz/oauth/v2/token';
    public const API_DETAIL_ORGANIZATION = 'https://app.gosms.cz/api/v1/';
    public const API_SEND_MESSAGE = 'https://app.gosms.cz/api/v1/messages';
    public const API_DETAIL_MESSAGE = 'https://app.gosms.cz/api/v1/messages/%s';
    public const API_DELETE_MESSAGE = 'https://app.gosms.cz/api/v1/messages/%s';
    public const API_REPLIES_MESSAGE = 'https://app.gosms.cz/api/v1/messages/%s/replies';

    /**
     * @var RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface
     */
    private $streamFactory;

    public function __construct(RequestFactoryInterface $requestFactory, StreamFactoryInterface $streamFactory)
    {
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory;
    }

    public function requestAccessToken(ClientCredentials $credentials): RequestInterface
    {
        $data = [
            'client_id' => $credentials->getClientId(),
            'client_secret' => $credentials->getClientSecret(),
            'grant_type' => 'client_credentials'
        ];

        return $this->requestFactory->createRequest('POST', self::API_TOKEN)
            ->withBody($this->encodeHttpBody($data))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    public function requestDetailOrganization(): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', self::API_DETAIL_ORGANIZATION);
    }

    public function requestSendMessage(SendMessage $sendMessage): RequestInterface
    {
        return $this->requestFactory->createRequest('POST', self::API_SEND_MESSAGE)
            ->withBody($this->encodeJsonBody($sendMessage->toArray()))
            ->withHeader('Content-Type', 'application/json');
    }

    public function requestDetailMessage(int $messageId): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', sprintf(self::API_DETAIL_MESSAGE, $messageId));
    }

    public function requestDeleteMessage(int $messageId): RequestInterface
    {
        return $this->requestFactory->createRequest('DELETE', sprintf(self::API_DELETE_MESSAGE, $messageId));
    }

    public function requestRepliesMessage(int $messageId): RequestInterface
    {
        return $this->requestFactory->createRequest('GET', sprintf(self::API_REPLIES_MESSAGE, $messageId));
    }

    /**
     * @param array<mixed> $data
     */
    private function encodeJsonBody(array $data): StreamInterface
    {
        $content = json_encode($data);

        if ($content === false) {
            throw new RuntimeException('Json encoding failure');
        }

        return $this->streamFactory->createStream($content);
    }

    /**
     * @param array<mixed> $data
     */
    private function encodeHttpBody(array $data): StreamInterface
    {
        $content = http_build_query($data);

        return $this->streamFactory->createStream($content);
    }
}
