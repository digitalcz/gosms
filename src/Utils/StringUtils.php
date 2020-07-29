<?php

declare(strict_types=1);

namespace DigitalCz\GoSms\Utils;

use DigitalCz\GoSms\Exception\RuntimeException;

class StringUtils
{
    public static function resolveIdFromLink(string $link): int
    {
        $linkParts = explode('/', $link);

        $id = end($linkParts);

        if (!intval($id)) {
            throw new RuntimeException(sprintf('Failed to parse id from link %s', $link));
        }

        return (int) $id;
    }
}
