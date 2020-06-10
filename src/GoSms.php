<?php

declare(strict_types=1);

namespace DigitalCz\GoSms;

use DigitalCz\GoSms\Http\Client;
use DigitalCz\GoSms\Request\RequestFactory;
use DigitalCz\GoSms\Response\ResponseObjectFactory;
use DigitalCz\GoSms\ValueObject\DetailMessage;
use DigitalCz\GoSms\ValueObject\DetailOrganization;
use DigitalCz\GoSms\ValueObject\RepliesMessage;
use DigitalCz\GoSms\ValueObject\SendMessage;

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
     * @var ResponseObjectFactory
     */
    private $responseObjectFactory;

    public function __construct(
        Client $client,
        RequestFactory $requestFactory,
        ResponseObjectFactory $responseObjectFactory
    ) {
        $this->client = $client;
        $this->requestFactory = $requestFactory;
        $this->responseObjectFactory = $responseObjectFactory;
    }

    public function getDetailOrganization(): DetailOrganization
    {
        $request = $this->requestFactory->requestDetailOrganization();
        $response = $this->client->request($request);

        return $this->responseObjectFactory->createDetailOrganization($response);
    }

    public function sendMessage(SendMessage $message): int
    {
        $request = $this->requestFactory->requestSendMessage($message);
        $response = $this->client->request($request);

        return $this->responseObjectFactory->createSendMessage($response);
    }

    public function detailMessage(int $messageId): DetailMessage
    {
        $request = $this->requestFactory->requestDetailMessage($messageId);
        $response = $this->client->request($request);

        return $this->responseObjectFactory->createDetailMessage($response);
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

        return $this->responseObjectFactory->createRepliesMessage($response);
    }
}
