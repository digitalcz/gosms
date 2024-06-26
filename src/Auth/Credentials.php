<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Auth;

use DigitalCz\GoSms\GoSms;

interface Credentials
{
    /**
     * Returns unique hash for every instance of credentials
     */
    public function getHash(): string;

    /**
     * Return auth Token for this credentials
     */
    public function provide(GoSms $goSms): Token;
}
