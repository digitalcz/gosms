<?php

declare(strict_types=1);

use DigitalCz\GoSms\GoSms;

require dirname(__DIR__) . '/vendor/autoload.php';

$goSms = new GoSms([
    'client_id' => '...',
    'client_secret' => '...',
]);

$messages = $goSms->messages();

$message = $messages->create(
    [
        'message' => 'Hello Hans, please call me back.',
        'recipients' => '+420775300500',
        'channel' => 6,
    ],
);
echo "Created Message " . $message->link() . PHP_EOL;

$message = $messages->get('example_message_id');
echo "Detail Message " . var_dump($message) . PHP_EOL;

$messages->delete('example_message_id');
echo "Message was deleted " . PHP_EOL;