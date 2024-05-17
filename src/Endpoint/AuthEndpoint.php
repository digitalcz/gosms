<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

use DigitalCz\GoSms\GoSms;
use DigitalCz\GoSms\Resource\Token;

/**
 * @extends ResourceEndpoint<Token>
 */
final class AuthEndpoint extends ResourceEndpoint
{
    public function __construct(GoSms $parent)
    {
        parent::__construct($parent, '/oauth/v2/token', Token::class, ['no_auth' => true]);
    }

    /**
     * @param mixed[] $body
     */
    public function authorize(array $body): Token
    {
        return $this->makeResource($this->postRequest('', ['multipart' => $body]));
    }
}
