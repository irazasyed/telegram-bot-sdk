<?php

declare(strict_types=1);




use Telegram\Bot\Objects\Chat;
use Telegram\Bot\Objects\Update;




it('parses chat relation for bot kicked event', function () {
    $update = new Update([
        // there is no "message" key at this even type!
        'my_chat_member' => [
            'chat' => [
                'id' => 42,
                'first_name' => 'Firstname',
                'last_name' => 'Lastname',
                'type' => 'private',
            ],
        ],
        'old_chat_member' => [
            'user' => [], // doesn't matter in this case
            'status' => 'member',
        ],
        'new_chat_member' => [
            'user' => [], // doesn't matter in this case
            'status' => 'kicked',
            'until_date' => 0,
        ],
    ]);




    expect($update->getChat())->toBeInstanceOf(Chat::class);
});

