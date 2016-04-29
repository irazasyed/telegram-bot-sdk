<?php

require_once 'vendor/autoload.php';

$telegram = new \Telegram\Bot\Api('141984924:AAGWpUpjFjBfTo323D_-nDDOxaRxVcdUiB0');

$telegram->getConversationBus()->addConversations([
    \Telegram\Bot\Conversations\HelloConversation::class,
    \Telegram\Bot\Conversations\LeaveMeAloneConversation::class,
]);

$telegram->conversationsHandler(false);