<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Endpoint;

use DigitalCz\GoSms\GoSms;
use DigitalCz\GoSms\Resource\Organization;

/**
 * @extends ResourceEndpoint<Organization>
 */
final class OrganizationEndpoint extends ResourceEndpoint
{
    public function __construct(GoSms $parent)
    {
        parent::__construct($parent, '/api/v1', Organization::class);
    }

    public function detail(): Organization
    {
        return $this->makeResource($this->getRequest(''));
    }
}
