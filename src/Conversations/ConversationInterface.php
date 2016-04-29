<?php

namespace Telegram\Bot\Conversations;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

interface ConversationInterface
{
    /**
     * Process Inbound Non-Command Message.
     *
     * @param Api $telegram
     * @param Update $update
     *
     * @return mixed
     */
    public function make(Api $telegram, Update $update);

    /**
     * Handle Conversation.
     *
     * @return mixed
     */
    public function handle();
}