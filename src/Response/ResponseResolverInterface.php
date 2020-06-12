<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Response;

use Psr\Http\Message\ResponseInterface;

interface ResponseResolverInterface
{
    /**
     * @return mixed
     */
    public function resolveAccessToken(ResponseInterface $response);

    /**
     * @return mixed
     */
    public function resolveSendMessage(ResponseInterface $response);

    /**
     * @return mixed
     */
    public function resolveDetailOrganization(ResponseInterface $response);

    /**
     * @return mixed
     */
    public function resolveDetailMessage(ResponseInterface $response);

    /**
     * @return mixed
     */
    public function resolveRepliesMessage(ResponseInterface $response);
}
