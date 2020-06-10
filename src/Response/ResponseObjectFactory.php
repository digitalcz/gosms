<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Response;

use DigitalCz\GoSms\Exception\RuntimeException;
use DigitalCz\GoSms\Utils\StringUtils;
use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\DetailMessage;
use DigitalCz\GoSms\ValueObject\DetailOrganization;
use DigitalCz\GoSms\ValueObject\RepliesMessage;
use Psr\Http\Message\ResponseInterface;

class ResponseObjectFactory
{
    public function createAccessToken(ResponseInterface $response): AccessToken
    {
        $data = $this->parseBody($response);

        return AccessToken::fromArray($data);
    }

    public function createDetailOrganization(ResponseInterface $response): DetailOrganization
    {
        $data = $this->parseBody($response);

        return DetailOrganization::fromArray($data);
    }

    public function createSendMessage(ResponseInterface $response): int
    {
        $data = $this->parseBody($response);

        return StringUtils::resolveIdFromLink($data['link']);
    }

    public function createDetailMessage(ResponseInterface $response): DetailMessage
    {
        $data = $this->parseBody($response);

        return DetailMessage::fromArray($data);
    }

    public function createRepliesMessage(ResponseInterface $response): RepliesMessage
    {
        $data = $this->parseBody($response);

        return RepliesMessage::fromArray($data);
    }

    /**
     * @return array<mixed>
     */
    private function parseBody(ResponseInterface $httpResponse): array
    {
        $json = $httpResponse->getBody()->getContents();

        $body = json_decode($json, true);

        if ($body === false) {
            throw new RuntimeException('Failed to parse result json');
        }

        return $body;
    }
}
