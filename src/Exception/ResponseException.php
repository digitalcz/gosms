<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Exception;

use DigitalCz\GoSms\GoSmsClient;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class ResponseException extends RuntimeException
{
    private ResponseInterface $response;

    public function __construct(
        ResponseInterface $response,
        ?string $message = null,
        ?int $code = null,
        ?Throwable $previous = null,
    ) {
        $this->response = $response;
        $code ??= $response->getStatusCode();
        $message ??= sprintf("%s %s", $response->getStatusCode(), $response->getReasonPhrase());

        try {
            $result = $this->parseResult();

            if (isset($result['title'])) {
                $message .= ': ' . $result['title'];
            }

            if (isset($result['detail'])) {
                $message .= ': ' . $result['detail'];
            }
        } catch (RuntimeException $e) {
            $message .= ': ' . $e->getMessage();
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Access its underlying response object.
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return mixed[]
     */
    protected function parseResult(): array
    {
        $result = GoSmsClient::parseResponse($this->getResponse());

        if ($result === null) {
            throw new EmptyResultException();
        }

        return $result;
    }
}
