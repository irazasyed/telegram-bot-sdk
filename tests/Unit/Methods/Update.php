<?php

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Methods\Update;

uses(Update::class);
test('a webhook url must use secure http', function () {
    $this->expectException(TelegramSDKException::class);
    $this->setWebhook([
        'url' => 'http://example.com',
    ]);
});

test('a webhook must have a valid url', function () {
    $this->expectException(TelegramSDKException::class);
    $this->setWebhook([
        'url' => 'not a valid url',
    ]);
});
