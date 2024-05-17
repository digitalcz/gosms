<?php

declare(strict_types=1);

namespace DigitalCz\GoSms;

use Psr\Http\Message\ResponseInterface;

interface GoSmsClientInterface
{
    /**
     * @param mixed[] $options
     */
    public function request(string $method, string $uri, array $options = []): ResponseInterface;
}
