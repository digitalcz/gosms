<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Response;

use DigitalCz\GoSms\Exception\RuntimeException;
use DigitalCz\GoSms\ValueObject\AccessToken;
use DigitalCz\GoSms\ValueObject\DetailMessage;
use DigitalCz\GoSms\ValueObject\DetailOrganization;
use DigitalCz\GoSms\ValueObject\RepliesMessage;
use DigitalCz\GoSms\ValueObject\SentMessage;
use Psr\Http\Message\ResponseInterface;

class ResponseObjectResolver implements ResponseResolverInterface
{
    public function resolveAccessToken(ResponseInterface $response): AccessToken
    {
        $data = $this->parseBody($response);

        return AccessToken::fromArray($data);
    }

    public function resolveDetailOrganization(ResponseInterface $response): DetailOrganization
    {
        $data = $this->parseBody($response);

        return DetailOrganization::fromArray($data);
    }

    public function resolveSendMessage(ResponseInterface $response): SentMessage
    {
        $data = $this->parseBody($response);

        return SentMessage::fromArray($data);
    }

    public function resolveDetailMessage(ResponseInterface $response): DetailMessage
    {
        $data = $this->parseBody($response);

        return DetailMessage::fromArray($data);
    }

    public function resolveRepliesMessage(ResponseInterface $response): RepliesMessage
    {
        $data = $this->parseBody($response);

        return RepliesMessage::fromArray($data);
    }

    /**
     * @return array<mixed>
     */
    private function parseBody(ResponseInterface $httpResponse): array
    {
        $body = json_decode((string)$httpResponse->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                sprintf('"%s" when parsing response body: "%s"', json_last_error_msg(), $httpResponse->getBody())
            );
        }

        return $body;
    }
}
