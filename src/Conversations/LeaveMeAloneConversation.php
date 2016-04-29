<?php

namespace Telegram\Bot\Conversations;

/**
 * Class HelloConversation
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
