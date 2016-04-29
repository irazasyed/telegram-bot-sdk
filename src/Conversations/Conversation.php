<?php


namespace Telegram\Bot\Conversations;

use Telegram\Bot\Answers\Answer;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class Conversation
 */
abstract class Conversation extends Answer implements ConversationInterface
{
    /**
     * @inheritdoc
     */
    public function make(Api $telegram, Update $update)
    {
        $this->telegram = $telegram;
        $this->update = $update;

        return $this->handle();
    }

    /**
     * @inheritdoc
     */
    abstract public function handle();
}
