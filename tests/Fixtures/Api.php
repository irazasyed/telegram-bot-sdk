<?php

function sendMessage(): array
{
    return [
        'chat_id' => 12345678,
        'text' => 'lorem ipsum',
        'disable_web_page_preview' => true,
        'disable_notification' => false,
        'reply_to_message_id' => 99999999,
    ];
}

function updatesPayload(): array
{
    return [
        [
            'update_id' => 377695760,
            'message' => [
                'message_id' => 749,
                'from' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                ],
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                    'type' => 'private',
                ],
                'date' => 1494623093,
                'text' => 'Test1',
            ],
        ],
        [
            'update_id' => 377695761,
            'message' => [
                'message_id' => 750,
                'from' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                ],
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                    'type' => 'private',
                ],
                'date' => 149462395,
                'text' => 'Test2',
            ],
        ],
    ];
}

function updatesPayload2(): array
{
    return [
        [
            'update_id' => 377695762,
            'message' => [
                'message_id' => 751,
                'from' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                ],
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                    'type' => 'private',
                ],
                'date' => 1494623093,
                'text' => 'Test3',
            ],
        ],
        [
            'update_id' => 377695763,
            'message' => [
                'message_id' => 752,
                'from' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                ],
                'chat' => [
                    'id' => 123456789,
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'username' => 'jdoe',
                    'type' => 'private',
                ],
                'date' => 1494623095,
                'text' => 'Test4',
            ],
        ],
    ];
}

function pubKey(): string
{
    return <<<'EOT'
-----BEGIN PUBLIC KEY-----
THISISSOMERANDOMKEYDATA
-----END PUBLIC KEY-----
EOT;
}
