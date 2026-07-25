<?php

use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;
use Telegram\Bot\Commands\CommandBus;

return [
    'facade' => Telegram\Bot\Laravel\Facades\Telegram::class,

    'classes' => [
        BotsManager::class,
        Api::class => [
            'setContainer',
            'getWebhookUpdates',
        ],
        CommandBus::class => [
            'getTelegram',
            'setTelegram',
        ],
    ],

    'excludedMethods' => [],
];
