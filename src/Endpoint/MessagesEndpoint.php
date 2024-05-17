<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

use DigitalCz\GoSms\GoSms;
use DigitalCz\GoSms\Resource\Message;
use DigitalCz\GoSms\Resource\MessageReplies;
use DigitalCz\GoSms\Resource\MessageTest;

/**
 * @extends ResourceEndpoint<Message>
 */
final class MessagesEndpoint extends ResourceEndpoint
{
    public function __construct(GoSms $parent)
    {
        parent::__construct($parent, '/api/v1/messages', Message::class);
    }

    /**
     * @param mixed[] $body
     */
    public function create(array $body): Message
    {
        return $this->makeResource($this->postRequest('', ['json' => $body]));
    }

    /**
     * @param mixed[] $body
     */
    public function test(array $body): MessageTest
    {
        return $this->createResource($this->postRequest('/test', ['json' => $body]), MessageTest::class);
    }

    public function get(string $id): Message
    {
        return $this->makeResource($this->getRequest('/{id}', ['id' => $id]));
    }

    public function delete(string $id): void
    {
        $this->deleteRequest('/{id}', ['id' => $id]);
    }

    public function replies(string $id): MessageReplies
    {
        return $this->createResource($this->getRequest('/{id}/replies', ['id' => $id]), MessageReplies::class);
    }
}
