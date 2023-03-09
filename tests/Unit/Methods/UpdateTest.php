<?php

use Telegram\Bot\Exceptions\TelegramSDKException;
uses(\Telegram\Bot\Methods\Update::class);
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
