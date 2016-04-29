<?php


namespace Telegram\Bot\Conversations;

use Telegram\Bot\Answers\Answerable;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class Conversation
 */
abstract class Conversation implements ConversationInterface
{
    use Answerable;

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
