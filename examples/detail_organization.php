<?php

declare(strict_types=1);

use DigitalCz\GoSms\GoSms;

require dirname(__DIR__) . '/vendor/autoload.php';

$goSms = new GoSms([
    'client_id' => '...',
    'client_secret' => '...',
]);

$organization = $goSms->organization()->detail();

echo "Detail Message " . var_dump($organization) . PHP_EOL; // @phpstan-ignore-line
