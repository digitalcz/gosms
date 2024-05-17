<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Exception;

use DigitalCz\GoSms\Resource\Violations;

/**
 * Represents response with http status 400
 */
final class BadRequestException extends ClientException
{
    public function getViolations(): ?Violations
    {
        try {
            return new Violations($this->parseResult());
        } catch (EmptyResultException) {
            return null;
        }
    }
}
