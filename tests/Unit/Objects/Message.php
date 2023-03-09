<?php

use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\PhotoSize;

it('inits one to many relation', function () {
    $message = Message::make([
        'photo' => [
            ['file_id' => ''],
            ['file_id' => ''],
            ['file_id' => ''],
            ['file_id' => ''],
        ],
    ]);

    expect($message->photo)->toBeIterable();
    expect($message->photo)->toHaveCount(4);
    expect($message->photo[0])->toBeInstanceOf(PhotoSize::class);
    expect($message->photo[1])->toBeInstanceOf(PhotoSize::class);
    expect($message->photo[2])->toBeInstanceOf(PhotoSize::class);
    expect($message->photo[3])->toBeInstanceOf(PhotoSize::class);
});
