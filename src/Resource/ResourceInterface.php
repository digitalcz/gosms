<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Resource;

use DigitalCz\GoSms\Exception\RuntimeException;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface;

interface ResourceInterface extends JsonSerializable
{
    /**
     * Returns original API response
     *
     * @return ResponseInterface The original response
     *
     * @throws RuntimeException If this resource has no Response set
     */
    public function getResponse(): ResponseInterface;

    /**
     * Set original API response
     */
    public function setResponse(ResponseInterface $response): void;

    /**
     * Returns original values from API response
     *
     * @return mixed[]
     */
    public function getResult(): array;

    /**
     * Returns array representation of Resource
     *
     * @return mixed[]
     */
    public function toArray(): array;

    /**
     * Returns IRI for Resource
     *
     * @throws RuntimeException if Resource has no self link
     */
    public function link(): string;

    /**
     * Returns ID for Resource
     *
     * @throws RuntimeException if Resource has no ID
     */
    public function id(): string;
}
