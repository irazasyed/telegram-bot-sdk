<?php

function botsManager(): array {
    return [
        'default' => 'bot1',
        'bots' => [
            'bot1' => [
                'username' => 'BotOne_Bot',
                'token' => 'TOKEN1',
                'commands' => [],
            ],
            'bot2' => [
                'username' => 'BotTwo_Bot',
                'token' => 'TOKEN2',
                'commands' => [],
            ],
            'bot3' => [
                'username' => 'BotThree_Bot',
                'token' => 'TOKEN3',
                'commands' => [],
            ],
        ],
        'resolve_command_dependencies' => true,
        'commands' => [
            //      Telegram\Bot\Commands\HelpCommand::class,
        ],
    ];
}