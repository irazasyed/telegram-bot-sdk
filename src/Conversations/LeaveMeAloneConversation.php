<?php

namespace Telegram\Bot\Conversations;

/**
 * Class HelloConversation
 * @package Telegram\Bot\Conversations
 * @author Artiom Mocrenco <tjomamokrenko@gmail.com>
 */
class LeaveMeAloneConversation extends Conversation
{
    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage(['text' => 'Leave me alone, please.']);
    }

}